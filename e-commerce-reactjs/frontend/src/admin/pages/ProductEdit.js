import React, { useState, useEffect } from 'react';
import { Form, Button, Card, Row, Col, Alert } from 'react-bootstrap';
import { useNavigate, useParams } from 'react-router-dom';
import axios from 'axios';
import '../styles/admin.css';

function ProductEdit() {
    const navigate = useNavigate();
    const { id } = useParams();
    const [product, setProduct] = useState({
        productName: '',
        description: '',
        price: '',
        quantity: '',
        discount: 0
    });
    const [selectedCategory, setSelectedCategory] = useState('');
    const [categories, setCategories] = useState([]);
    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [error, setError] = useState('');
    const [selectedImage, setSelectedImage] = useState(null);
    const [imagePreview, setImagePreview] = useState('');
    const [additionalImages, setAdditionalImages] = useState({
        image1: null,
        image2: null,
        image3: null
    });
    const [additionalPreviews, setAdditionalPreviews] = useState({
        image1: null,
        image2: null,
        image3: null
    });

    useEffect(() => {
        fetchProduct();
        fetchCategories();
    }, [id]);

    const fetchProduct = async () => {
        try {
            const response = await axios.get(`/api/public/products/${id}`);
            const productData = response.data;
            setProduct(productData);
            setSelectedCategory(productData.category?.id || '');
            if (productData.image) {
                setImagePreview(`http://localhost:8080/api/public/products/image/${productData.image}`);
            }

            // Fetch additional images
            try {
                const imagesResponse = await axios.get(`http://localhost:8080/api/public/products/${id}/images`);
                if (imagesResponse.data && imagesResponse.data[0]) {
                    const images = imagesResponse.data[0];
                    setAdditionalPreviews({
                        image1: images.image1 ? `http://localhost:8080/api/public/products/image/${images.image1}` : null,
                        image2: images.image2 ? `http://localhost:8080/api/public/products/image/${images.image2}` : null,
                        image3: images.image3 ? `http://localhost:8080/api/public/products/image/${images.image3}` : null
                    });
                }
            } catch (error) {
                console.error('Failed to fetch additional images:', error);
            }

            setLoading(false);
        } catch (error) {
            console.error('Error fetching product:', error);
            setError('Failed to load product. Please try again.');
            setLoading(false);
        }
    };

    const fetchCategories = async () => {
        try {
            const response = await axios.get('/api/public/categories');
            setCategories(response.data.content || []);
        } catch (error) {
            console.error('Error fetching categories:', error);
            setError('Failed to load categories. Please try again.');
        }
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setProduct({
            ...product,
            [name]: name === 'price' || name === 'quantity' || name === 'discount' 
                ? parseFloat(value) || 0 
                : value
        });
    };

    const handleCategoryChange = (e) => {
        const categoryId = parseInt(e.target.value);
        setSelectedCategory(categoryId);
    };

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setSelectedImage(file);
            setImagePreview(URL.createObjectURL(file));
        }
    };

    const handleAdditionalImageChange = (e, imageKey) => {
        const file = e.target.files[0];
        if (file) {
            setAdditionalImages(prev => ({
                ...prev,
                [imageKey]: file
            }));
            setAdditionalPreviews(prev => ({
                ...prev,
                [imageKey]: URL.createObjectURL(file)
            }));
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (!selectedCategory) {
            setError('Please select a category');
            return;
        }

        setSaving(true);
        setError('');

        try {
            // Prepare product data with category
            const productData = {
                productId: product.productId,
                productName: product.productName,
                description: product.description,
                price: product.price,
                quantity: product.quantity,
                discount: product.discount,
                category: {
                    id: selectedCategory
                }
            };

            // Update product details
            await axios.put(`/api/admin/products/${id}`, productData);

            // Then update the main image if a new one was selected
            if (selectedImage) {
                const formData = new FormData();
                formData.append('image', selectedImage);
                await axios.put(`/api/admin/products/${id}/image`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
            }

            // Update additional images if any are selected
            const hasAdditionalImages = Object.values(additionalImages).some(img => img !== null);
            if (hasAdditionalImages) {
                const additionalImagesForm = new FormData();
                if (additionalImages.image1) additionalImagesForm.append('image1', additionalImages.image1);
                if (additionalImages.image2) additionalImagesForm.append('image2', additionalImages.image2);
                if (additionalImages.image3) additionalImagesForm.append('image3', additionalImages.image3);

                await axios.put(
                    `/api/admin/products/${id}/additional-images`,
                    additionalImagesForm,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                );
            }

            navigate('/admin/products');
        } catch (error) {
            console.error('Error updating product:', error);
            setError(error.response?.data?.message || 'Failed to update product. Please try again.');
            setSaving(false);
        }
    };

    if (loading) {
        return <div>Loading...</div>;
    }

    return (
        <div>
            <h2 className="admin-form-title">Edit Product</h2>
            
            <Card className="admin-card">
                <Card.Body>
                    {error && <Alert variant="danger" className="admin-alert">{error}</Alert>}
                    
                    <Form onSubmit={handleSubmit}>
                        <Row>
                            <Col md={6}>
                                <Form.Group className="admin-form-group">
                                    <Form.Label className="admin-form-label">Product Name</Form.Label>
                                    <Form.Control
                                        className="admin-form-control"
                                        type="text"
                                        name="productName"
                                        value={product.productName}
                                        onChange={handleChange}
                                        required
                                    />
                                </Form.Group>
                            </Col>
                            <Col md={6}>
                                <Form.Group className="admin-form-group">
                                    <Form.Label className="admin-form-label">Category</Form.Label>
                                    <Form.Select
                                        className="admin-form-control"
                                        value={selectedCategory}
                                        onChange={handleCategoryChange}
                                        required
                                    >
                                        <option value="">Select a category</option>
                                        {categories.map(category => (
                                            <option key={category.id} value={category.id}>
                                                {category.name}
                                            </option>
                                        ))}
                                    </Form.Select>
                                </Form.Group>
                            </Col>
                        </Row>
                        
                        <Form.Group className="admin-form-group">
                            <Form.Label className="admin-form-label">Description</Form.Label>
                            <Form.Control
                                className="admin-form-control"
                                as="textarea"
                                rows={3}
                                name="description"
                                value={product.description}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>

                        <Form.Group className="admin-form-group">
                            <Form.Label className="admin-form-label">Main Product Image</Form.Label>
                            <div className="d-flex align-items-center gap-3">
                                {imagePreview && (
                                    <div className="mb-2">
                                        <img 
                                            src={imagePreview} 
                                            alt="Product preview" 
                                            style={{ 
                                                width: '100px', 
                                                height: '100px', 
                                                objectFit: 'contain',
                                                borderRadius: '4px',
                                                border: '1px solid #dee2e6',
                                                padding: '4px',
                                                backgroundColor: '#fff'
                                            }}
                                        />
                                    </div>
                                )}
                                <Form.Control
                                    className="admin-form-control"
                                    type="file"
                                    accept="image/*"
                                    onChange={handleImageChange}
                                />
                            </div>
                        </Form.Group>

                        <Row className="mb-3">
                            <Col md={12}>
                                <h5 className="admin-form-label">Additional Images</h5>
                            </Col>
                            {['image1', 'image2', 'image3'].map((imageKey, index) => (
                                <Col md={4} key={imageKey}>
                                    <Form.Group className="admin-form-group">
                                        <Form.Label className="admin-form-label">Image {index + 1}</Form.Label>
                                        <div className="d-flex align-items-center gap-3">
                                            <Form.Control
                                                className="admin-form-control"
                                                type="file"
                                                accept="image/*"
                                                onChange={(e) => handleAdditionalImageChange(e, imageKey)}
                                            />
                                            {additionalPreviews[imageKey] && (
                                                <img 
                                                    src={additionalPreviews[imageKey]} 
                                                    alt={`Preview ${index + 1}`} 
                                                    style={{ 
                                                        width: '100px', 
                                                        height: '100px', 
                                                        objectFit: 'contain',
                                                        borderRadius: '4px',
                                                        border: '1px solid #dee2e6',
                                                        padding: '4px',
                                                        backgroundColor: '#fff'
                                                    }} 
                                                />
                                            )}
                                        </div>
                                    </Form.Group>
                                </Col>
                            ))}
                        </Row>
                        
                        <Row>
                            <Col md={4}>
                                <Form.Group className="admin-form-group">
                                    <Form.Label className="admin-form-label">Price (VND)</Form.Label>
                                    <Form.Control
                                        className="admin-form-control"
                                        type="number"
                                        name="price"
                                        value={product.price}
                                        onChange={handleChange}
                                        min="0"
                                        step="1000"
                                        required
                                    />
                                </Form.Group>
                            </Col>
                            <Col md={4}>
                                <Form.Group className="admin-form-group">
                                    <Form.Label className="admin-form-label">Quantity</Form.Label>
                                    <Form.Control
                                        className="admin-form-control"
                                        type="number"
                                        name="quantity"
                                        value={product.quantity}
                                        onChange={handleChange}
                                        min="0"
                                        required
                                    />
                                </Form.Group>
                            </Col>
                            <Col md={4}>
                                <Form.Group className="admin-form-group">
                                    <Form.Label className="admin-form-label">Discount (%)</Form.Label>
                                    <Form.Control
                                        className="admin-form-control"
                                        type="number"
                                        name="discount"
                                        value={product.discount}
                                        onChange={handleChange}
                                        min="0"
                                        max="100"
                                    />
                                </Form.Group>
                            </Col>
                        </Row>

                        <div className="mt-3">
                            {product.price && product.discount > 0 && (
                                <Alert variant="info" className="admin-alert">
                                    Special Price: {new Intl.NumberFormat('vi-VN', {
                                        style: 'currency',
                                        currency: 'VND'
                                    }).format(product.price - (product.price * (product.discount / 100)))}
                                </Alert>
                            )}
                        </div>
                        
                        <div className="d-flex justify-content-between mt-4">
                            <Button 
                                variant="secondary" 
                                onClick={() => navigate('/admin/products')}
                                className="admin-btn"
                            >
                                Cancel
                            </Button>
                            <Button 
                                variant="primary" 
                                type="submit" 
                                disabled={saving}
                                className="admin-btn"
                            >
                                {saving ? 'Saving...' : 'Save Changes'}
                            </Button>
                        </div>
                    </Form>
                </Card.Body>
            </Card>
        </div>
    );
}

export default ProductEdit; 