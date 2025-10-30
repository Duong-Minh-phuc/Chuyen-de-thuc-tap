import React, { useState, useEffect } from 'react';
import { Form, Button, Card, Alert } from 'react-bootstrap';
import { useNavigate, useParams } from 'react-router-dom';
import axios from 'axios';
import '../styles/admin.css';

function BannerEdit() {
    const navigate = useNavigate();
    const { id } = useParams();
    const [banner, setBanner] = useState({
        name: '',
        active: false
    });
    const [image, setImage] = useState(null);
    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [error, setError] = useState('');
    const [imagePreview, setImagePreview] = useState(null);

    useEffect(() => {
        fetchBanner();
    }, [id]);

    const fetchBanner = async () => {
        try {
            const response = await axios.get(`http://localhost:8080/api/public/banners/${id}`);
            setBanner({
                name: response.data.name,
                active: response.data.active
            });
            setImagePreview(`http://localhost:8080/api/public/banners/image/${response.data.image}`);
            setLoading(false);
        } catch (error) {
            console.error('Error fetching banner:', error);
            setError('Failed to load banner. Please try again.');
            setLoading(false);
        }
    };

    const handleChange = (e) => {
        const { name, value, type, checked } = e.target;
        setBanner({
            ...banner,
            [name]: type === 'checkbox' ? checked : value
        });
    };

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setImage(file);
            // Create preview URL
            const reader = new FileReader();
            reader.onloadend = () => {
                setImagePreview(reader.result);
            };
            reader.readAsDataURL(file);
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setSaving(true);
        setError('');

        try {
            // First update the banner details
            await axios.put(`http://localhost:8080/api/admin/banners/${id}`, {
                name: banner.name,
                active: banner.active
            });

            // Then update the image if a new one is selected
            if (image) {
                const formData = new FormData();
                formData.append('image', image);
                await axios.put(`http://localhost:8080/api/admin/banners/${id}/image`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
            }

            navigate('/admin/banners');
        } catch (error) {
            console.error('Error updating banner:', error);
            setError(error.response?.data?.message || 'Failed to update banner. Please try again.');
            setSaving(false);
        }
    };

    if (loading) {
        return <div>Loading...</div>;
    }

    return (
        <div>
            <h2 className="admin-form-title">Edit Banner</h2>
            
            <Card className="admin-card">
                <Card.Body>
                    {error && <Alert variant="danger" className="admin-alert">{error}</Alert>}
                    
                    <Form onSubmit={handleSubmit}>
                        <Form.Group className="admin-form-group">
                            <Form.Label className="admin-form-label">Banner Name</Form.Label>
                            <Form.Control
                                className="admin-form-control"
                                type="text"
                                name="name"
                                value={banner.name}
                                onChange={handleChange}
                                required
                                placeholder="Enter banner name"
                            />
                        </Form.Group>

                        <Form.Group className="admin-form-group">
                            <Form.Label className="admin-form-label">Banner Image</Form.Label>
                            <Form.Control
                                className="admin-form-control"
                                type="file"
                                accept="image/*"
                                onChange={handleImageChange}
                            />
                            {imagePreview && (
                                <img 
                                    src={imagePreview} 
                                    alt="Preview" 
                                    className="mt-2"
                                    style={{ maxHeight: '200px' }}
                                />
                            )}
                        </Form.Group>

                        <Form.Group className="admin-form-group">
                            <Form.Check
                                type="checkbox"
                                name="active"
                                checked={banner.active}
                                onChange={handleChange}
                                label="Active"
                                className="admin-form-check-label"
                            />
                        </Form.Group>
                        
                        <div className="d-flex justify-content-between mt-4">
                            <Button 
                                variant="secondary" 
                                onClick={() => navigate('/admin/banners')}
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

export default BannerEdit; 