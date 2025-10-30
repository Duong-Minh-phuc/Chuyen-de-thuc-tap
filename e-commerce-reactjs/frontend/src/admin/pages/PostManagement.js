import React, { useState, useEffect } from 'react';
import { Table, Button, Card, Nav, Badge } from 'react-bootstrap';
import { FaCheck, FaTrash } from 'react-icons/fa';
import axios from 'axios';
import '../styles/admin.css';

function PostManagement() {
    const [posts, setPosts] = useState([]);
    const [activeTab, setActiveTab] = useState('pending');
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        fetchPosts();
    }, [activeTab]);

    const fetchPosts = async () => {
        try {
            const endpoint = activeTab === 'pending' 
                ? '/api/admin/posts/pending'
                : '/api/admin/posts/approved';
            
            const response = await axios.get(`http://localhost:8080${endpoint}`);
            setPosts(response.data);
        } catch (err) {
            setError('Unable to load posts.');
        } finally {
            setLoading(false);
        }
    };

    const handleApprove = async (postId) => {
        try {
            await axios.put(`http://localhost:8080/api/admin/posts/${postId}/approve`);
            fetchPosts();
        } catch (err) {
            setError('Unable to approve post.');
        }
    };

    const handleDelete = async (postId) => {
        if (window.confirm('Are you sure you want to delete this post?')) {
            try {
                await axios.delete(`http://localhost:8080/api/posts/${postId}`);
                fetchPosts();
            } catch (err) {
                setError('Unable to delete post.');
            }
        }
    };

    if (loading) return <div className="loading-spinner">Loading...</div>;

    return (
        <div className="page-container">
            <div className="page-header">
                <h2 className="admin-form-title">Post Management</h2>
            </div>

            <Card className="admin-card mb-4">
                <Card.Body>
                    <Nav variant="tabs" className="custom-tabs">
                        <Nav.Item>
                            <Nav.Link 
                                active={activeTab === 'pending'}
                                onClick={() => setActiveTab('pending')}
                                className={`tab-link ${activeTab === 'pending' ? 'fw-bold' : ''}`}
                                style={{ 
                                    fontSize: '1.1rem',
                                    color: activeTab === 'pending' ? '#2c3e50' : '#666'
                                }}
                            >
                                Pending
                                {activeTab === 'pending' && posts.length > 0 && (
                                    <Badge bg="danger" className="ms-2">
                                        {posts.length}
                                    </Badge>
                                )}
                            </Nav.Link>
                        </Nav.Item>
                        <Nav.Item>
                            <Nav.Link 
                                active={activeTab === 'approved'}
                                onClick={() => setActiveTab('approved')}
                                className={`tab-link ${activeTab === 'approved' ? 'fw-bold' : ''}`}
                                style={{ 
                                    fontSize: '1.1rem',
                                    color: activeTab === 'approved' ? '#2c3e50' : '#666'
                                }}
                            >
                                Approved
                            </Nav.Link>
                        </Nav.Item>
                    </Nav>
                </Card.Body>
            </Card>

            {error && <div className="alert alert-danger">{error}</div>}

            <Card className="admin-card table-container">
                <Card.Body>
                    <Table responsive hover className="admin-table">
                        <thead>
                            <tr>
                                <th className="fw-bold">ID</th>
                                <th className="fw-bold">User</th>
                                <th className="fw-bold">Content</th>
                                <th className="fw-bold">Image</th>
                                <th className="fw-bold">Created Date</th>
                                <th className="fw-bold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {posts.map(post => (
                                <tr key={post.id}>
                                    <td>{post.id}</td>
                                    <td>{post.userName}</td>
                                    <td>{post.content}</td>
                                    <td>
                                        {post.image && (
                                            <img
                                                src={`http://localhost:8080/api/public/posts/image/${post.image}`}
                                                alt="Post"
                                                className="post-thumbnail"
                                            />
                                        )}
                                    </td>
                                    <td>
                                        {new Date(post.createdAt).toLocaleDateString('en-US', {
                                            year: 'numeric',
                                            month: 'short',
                                            day: 'numeric'
                                        })}
                                    </td>
                                    <td>
                                        <div className="action-buttons">
                                            {activeTab === 'pending' && (
                                                <Button
                                                    variant="outline-success"
                                                    size="sm"
                                                    onClick={() => handleApprove(post.id)}
                                                    className="btn-icon btn-approve"
                                                >
                                                    <FaCheck />
                                                </Button>
                                            )}
                                            <Button
                                                variant="outline-danger"
                                                size="sm"
                                                onClick={() => handleDelete(post.id)}
                                                className="btn-icon btn-delete"
                                            >
                                                <FaTrash />
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </Table>

                    {posts.length === 0 && (
                        <div className="text-center py-3">
                            <p className="text-muted mb-0 fw-bold">
                                {activeTab === 'pending' 
                                    ? 'No pending posts.'
                                    : 'No approved posts.'}
                            </p>
                        </div>
                    )}
                </Card.Body>
            </Card>
        </div>
    );
}

export default PostManagement; 