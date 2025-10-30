import React, { useState, useEffect } from 'react';
import { Form, Button, Card, Row, Col, Alert } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';

function ProductCreate() {
    const navigate = useNavigate();
    const [product, setProduct] = useState({
        productName: '',
        description: '',
        price: '',
        quantity: '',
        discount: 0
    });
    const [imageFile, setImageFile] = useState(null);
    const [imagePreview, setImagePreview] = useState(null);
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
    const [categories, setCategories] = useState([]);
    const [selectedCategory, setSelectedCategory] = useState('');
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');

    useEffect(() => {
        fetchCategories();
    }, []);

    const fetchCategories = async () => {
        try {
            const response = await axios.get('/api/public/categories');
            console.log('Categories API response:', response.data);
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

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setImageFile(file);
            const previewUrl = URL.createObjectURL(file);
            setImagePreview(previewUrl);
        }
    };

    const handleAdditionalImageChange = (e, imageKey) => {
        const file = e.target.files[0];
        if (file) {
            setAdditionalImages(prev => ({
                ...prev,
                [imageKey]: file
            }));
            const previewUrl = URL.createObjectURL(file);
            setAdditionalPreviews(prev => ({
                ...prev,
                [imageKey]: previewUrl
            }));
        }
    };

    const handleCategoryChange = (e) => {
        const categoryId = parseInt(e.target.value);
        setSelectedCategory(categoryId);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (!selectedCategory) {
            setError('Please select a category');
            return;
        }

        setLoading(true);
        setError('');

        try {
            // First create the product
            const productData = {
                productName: product.productName,
                description: product.description,
                price: product.price,
                quantity: product.quantity,
                discount: product.discount
            };

            const productResponse = await axios.post(
                `/api/admin/categories/${selectedCategory}/products`, 
                productData
            );

            const productId = productResponse.data.productId;

            // Upload main image if selected
            if (imageFile) {
                const mainImageForm = new FormData();
                mainImageForm.append('image', imageFile);
                await axios.put(
                    `/api/admin/products/${productId}/image`,
                    mainImageForm,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                );
            }

            // Upload additional images if any are selected
            const hasAdditionalImages = Object.values(additionalImages).some(img => img !== null);
            if (hasAdditionalImages) {
                const additionalImagesForm = new FormData();
                if (additionalImages.image1) additionalImagesForm.append('image1', additionalImages.image1);
                if (additionalImages.image2) additionalImagesForm.append('image2', additionalImages.image2);
                if (additionalImages.image3) additionalImagesForm.append('image3', additionalImages.image3);

                await axios.put(
                    `/api/admin/products/${productId}/additional-images`,
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
            console.error('Error creating product:', error);
            setError(error.response?.data?.message || 'Failed to create product. Please try again.');
            setLoading(false);
        }
    };

    return (
        <div>
            <h2 className="mb-4">Add New Product</h2>
            
            <Card>
                <Card.Body>
                    {error && <Alert variant="danger">{error}</Alert>}
                    
                    <Form onSubmit={handleSubmit}>
                        <Row>
                            <Col md={6}>
                                <Form.Group className="mb-3">
                                    <Form.Label>Product Name</Form.Label>
                                    <Form.Control
                                        type="text"
                                        name="productName"
                                        value={product.productName}
                                        onChange={handleChange}
                                        required
                                    />
                                </Form.Group>
                            </Col>
                            <Col md={6}>
                                <Form.Group className="mb-3">
                                    <Form.Label>Category</Form.Label>
                                    <Form.Select
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
                        
                        <Form.Group className="mb-3">
                            <Form.Label>Description</Form.Label>
                            <Form.Control
                                as="textarea"
                                rows={3}
                                name="description"
                                value={product.description}
                                onChange={handleChange}
                                required
                            />
                        </Form.Group>

                        <Row className="mb-3">
                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Main Product Image</Form.Label>
                                    <div className="d-flex align-items-center gap-3">
                                        <Form.Control
                                            type="file"
                                            accept="image/*"
                                            onChange={handleImageChange}
                                        />
                                        {imagePreview && (
                                            <img 
                                                src={imagePreview} 
                                                alt="Preview" 
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
                        </Row>

                        <Row className="mb-3">
                            <Col md={12}>
                                <h5>Additional Images</h5>
                            </Col>
                            {['image1', 'image2', 'image3'].map((imageKey, index) => (
                                <Col md={4} key={imageKey}>
                                    <Form.Group>
                                        <Form.Label>Image {index + 1}</Form.Label>
                                        <div className="d-flex align-items-center gap-3">
                                            <Form.Control
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
                                <Form.Group className="mb-3">
                                    <Form.Label>Price (VND)</Form.Label>
                                    <Form.Control
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
                                <Form.Group className="mb-3">
                                    <Form.Label>Quantity</Form.Label>
                                    <Form.Control
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
                                <Form.Group className="mb-3">
                                    <Form.Label>Discount (%)</Form.Label>
                                    <Form.Control
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
                                <Alert variant="info">
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
                            >
                                Cancel
                            </Button>
                            <Button 
                                variant="primary" 
                                type="submit" 
                                disabled={loading}
                            >
                                {loading ? 'Creating...' : 'Create Product'}
                            </Button>
                        </div>
                    </Form>
                </Card.Body>
            </Card>
        </div>
    );
}

export default ProductCreate; 