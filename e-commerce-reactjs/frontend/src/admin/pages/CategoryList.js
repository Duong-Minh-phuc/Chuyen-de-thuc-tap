import React, { useState, useEffect } from 'react';
import { Table, Button, Card, Alert } from 'react-bootstrap';
import { Link } from 'react-router-dom';
import { FaEdit, FaTrash, FaPlus } from 'react-icons/fa';
import axios from 'axios';

function CategoryList() {
    const [categories, setCategories] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
    const [totalPages, setTotalPages] = useState(0);

    useEffect(() => {
        fetchCategories();
    }, [currentPage]);

    const fetchCategories = async () => {
        try {
            const response = await axios.get(`http://localhost:8080/api/public/categories`);
            console.log('Categories response:', response.data); // Add this for debugging
            if (response.data && response.data.content) {
                setCategories(response.data.content);
                setTotalPages(response.data.totalPages);
            }
            setLoading(false);
        } catch (error) {
            console.error('Error fetching categories:', error);
            setError('Failed to load categories. Please try again.');
            setLoading(false);
        }
    };

    const handleDelete = async (categoryId) => {
        if (window.confirm('Are you sure you want to delete this category?')) {
            try {
                await axios.delete(`http://localhost:8080/api/admin/categories/${categoryId}`);
                fetchCategories(); // Refresh the list
            } catch (error) {
                console.error('Error deleting category:', error);
                setError('Failed to delete category. Please try again.');
            }
        }
    };

    if (loading) {
        return <div className="loading-spinner">Loading...</div>;
    }

    return (
        <div className="page-container">
            <div className="page-header">
                <h2 className="page-title">Categories</h2>
                <Link to="/admin/categories/create">
                    <Button variant="primary" className="d-flex align-items-center gap-2">
                        <FaPlus /> Add New Category
                    </Button>
                </Link>
            </div>

            {error && <Alert variant="danger">{error}</Alert>}

            <Card className="table-container">
                <Card.Body>
                    <Table responsive hover className="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Number of Products</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {categories && categories.map(category => (
                                <tr key={category.id}>
                                    <td>{category.id}</td>
                                    <td>{category.name}</td>
                                    <td>
                                        <span className="badge bg-info">
                                            {category.products?.length || 0}
                                        </span>
                                    </td>
                                    <td>
                                        <div className="action-buttons">
                                            <Link to={`/admin/categories/edit/${category.id}`}>
                                                <Button 
                                                    variant="outline-primary" 
                                                    size="sm"
                                                    className="btn-icon btn-edit"
                                                >
                                                    <FaEdit />
                                                </Button>
                                            </Link>
                                            <Button 
                                                variant="outline-danger" 
                                                size="sm"
                                                onClick={() => handleDelete(category.id)}
                                                className="btn-icon btn-delete"
                                            >
                                                <FaTrash />
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                            {(!categories || categories.length === 0) && (
                                <tr>
                                    <td colSpan="4" className="text-center">No categories found</td>
                                </tr>
                            )}
                        </tbody>
                    </Table>

                    {totalPages > 1 && (
                        <div className="d-flex justify-content-center mt-4">
                            <Button
                                variant="outline-primary"
                                className="me-2"
                                disabled={currentPage === 1}
                                onClick={() => setCurrentPage(prev => prev - 1)}
                            >
                                Previous
                            </Button>
                            <Button
                                variant="outline-primary"
                                disabled={currentPage === totalPages}
                                onClick={() => setCurrentPage(prev => prev + 1)}
                            >
                                Next
                            </Button>
                        </div>
                    )}
                </Card.Body>
            </Card>
        </div>
    );
}

export default CategoryList; 