import React, { useState } from 'react';
import { Form, Button, Card, Alert } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import '../styles/admin.css';

function CategoryCreate() {
    const navigate = useNavigate();
    const [category, setCategory] = useState({
        categoryName: ''
    });
    const [saving, setSaving] = useState(false);
    const [error, setError] = useState('');

    const handleChange = (e) => {
        const { name, value } = e.target;
        setCategory({
            ...category,
            [name]: value
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (category.categoryName.length < 5) {
            setError('Category name must contain at least 5 characters');
            return;
        }

        setSaving(true);
        setError('');

        try {
            await axios.post('http://localhost:8080/api/admin/categories', category);
            navigate('/admin/categories');
        } catch (error) {
            console.error('Error creating category:', error);
            setError(error.response?.data?.message || 'Failed to create category. Please try again.');
            setSaving(false);
        }
    };

    return (
        <div>
            <h2 className="admin-form-title">Create New Category</h2>
            
            <Card className="admin-card">
                <Card.Body>
                    {error && <Alert variant="danger" className="admin-alert">{error}</Alert>}
                    
                    <Form onSubmit={handleSubmit}>
                        <Form.Group className="admin-form-group">
                            <Form.Label className="admin-form-label">Category Name</Form.Label>
                            <Form.Control
                                className="admin-form-control"
                                type="text"
                                name="categoryName"
                                value={category.categoryName}
                                onChange={handleChange}
                                required
                                minLength={5}
                                placeholder="Enter category name (minimum 5 characters)"
                            />
                        </Form.Group>
                        
                        <div className="d-flex justify-content-between mt-4">
                            <Button 
                                variant="secondary" 
                                onClick={() => navigate('/admin/categories')}
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
                                {saving ? 'Saving...' : 'Create Category'}
                            </Button>
                        </div>
                    </Form>
                </Card.Body>
            </Card>
        </div>
    );
}

export default CategoryCreate; 