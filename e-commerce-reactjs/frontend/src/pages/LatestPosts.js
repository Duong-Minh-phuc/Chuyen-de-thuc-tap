import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import './LatestPosts.css';
import { FaCalendarAlt, FaFolder } from 'react-icons/fa';

const LatestPosts = () => {
    const [posts, setPosts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [currentPage, setCurrentPage] = useState(1);
    const [totalPages, setTotalPages] = useState(0);

    useEffect(() => {
        const fetchPosts = async () => {
            try {
                setLoading(true);
                const response = await axios.get(
                    `http://127.0.0.1:8000/api/post?page=${currentPage}`
                );

                if (response.data.status) {
                    setPosts(response.data.data.data);
                    setTotalPages(response.data.data.last_page);
                }
            } catch (error) {
                console.error('Lỗi khi tải bài viết:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchPosts();
    }, [currentPage]);

    const formatDate = (dateString) => {
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric'
        };
        return new Date(dateString).toLocaleDateString('vi-VN', options);
    };

    if (loading) {
        return (
            <div className="latest-posts-loading">
                <div className="loading-spinner"></div>
                <p>Đang tải bài viết mới...</p>
            </div>
        );
    }

    return (
        <div className="latest-posts-container">
            <div className="latest-posts-header">
                <h1>Bài Viết Mới Nhất</h1>
                <p>Khám phá những thông tin mới nhất về nước hoa và làm đẹp</p>
            </div>

            <div className="latest-posts-grid">
                {posts.map((post) => (
                    <article key={post.id} className="post-card">
                        <div className="post-image">
                            <Link to={`/chi-tiet-bai-viet/${post.slug}`}>
                                <img
                                    src={`http://127.0.0.1:8000/images/post/${post.thumbnail}`}
                                    alt={post.title}
                                    onError={(e) => {
                                        e.target.src = "https://via.placeholder.com/400x250?text=No+Image";
                                    }}
                                />
                            </Link>
                            <div className="post-category">
                                <FaFolder />
                                <span>{post.topic.name}</span>
                            </div>
                        </div>

                        <div className="post-content">
                            <h2 className="post-title">
                                <Link to={`/chi-tiet-bai-viet/${post.slug}`}>{post.title}</Link>
                            </h2>

                            <div className="post-meta">
                                <div className="post-date">
                                    <FaCalendarAlt />
                                    <span>{formatDate(post.created_at)}</span>
                                </div>
                            </div>

                            <Link to={`/chi-tiet-bai-viet/${post.slug}`} className="read-more">
                                Đọc thêm
                            </Link>
                        </div>
                    </article>
                ))}
            </div>

            {totalPages > 1 && (
                <div className="pagination">
                    <button
                        className="pagination-button"
                        onClick={() => setCurrentPage(prev => Math.max(prev - 1, 1))}
                        disabled={currentPage === 1}
                    >
                        Trang trước
                    </button>

                    <span className="page-info">
                        Trang {currentPage} / {totalPages}
                    </span>

                    <button
                        className="pagination-button"
                        onClick={() => setCurrentPage(prev => Math.min(prev + 1, totalPages))}
                        disabled={currentPage === totalPages}
                    >
                        Trang sau
                    </button>
                </div>
            )}
        </div>
    );
};

export default LatestPosts; 