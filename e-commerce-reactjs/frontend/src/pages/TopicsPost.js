import React, { useState, useEffect } from 'react';
import { Link, useParams } from 'react-router-dom';
import axios from 'axios';
import './TopicsPost.css';
import { FaCalendarAlt, FaFolder, FaArrowLeft } from 'react-icons/fa';

const TopicsPost = () => {
    const [posts, setPosts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [currentPage, setCurrentPage] = useState(1);
    const [totalPages, setTotalPages] = useState(0);
    const [topic, setTopic] = useState(null);
    const { slug } = useParams();

    useEffect(() => {
        const fetchPosts = async () => {
            try {
                setLoading(true);
                // Lấy bài viết theo chủ đề
                const response = await axios.get(
                    `http://127.0.0.1:8000/api/post/topic/${slug}?page=${currentPage}`
                );

                if (response.data.status) {
                    setPosts(response.data.data.data);
                    setTotalPages(response.data.data.last_page);
                }

                // Lấy thông tin chủ đề
                const topicResponse = await axios.get(
                    `http://127.0.0.1:8000/api/topic/${slug}`
                );

                if (topicResponse.data.status) {
                    setTopic(topicResponse.data.data);
                }
            } catch (error) {
                console.error('Lỗi khi tải bài viết:', error);
            } finally {
                setLoading(false);
            }
        };

        if (slug) {
            fetchPosts();
        }
    }, [slug, currentPage]);

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
            <div className="posts-loading">
                <div className="loading-spinner"></div>
                <p>Đang tải bài viết...</p>
            </div>
        );
    }

    return (
        <div className="topics-post-container">
            <div className="topics-post-header">
                <div className="topic-navigation">
                    <Link to="/chu-de-bai-viet" className="back-link">
                        <FaArrowLeft /> Quay lại danh sách chủ đề
                    </Link>
                </div>
                <h1>{topic?.name || 'Bài viết theo chủ đề'}</h1>
                <p>{topic?.description || 'Khám phá các bài viết trong chủ đề này'}</p>
            </div>

            <div className="posts-grid">
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
                                <span>{post.topic_name}</span>
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
                        Trước
                    </button>

                    <span className="page-info">
                        Trang {currentPage} / {totalPages}
                    </span>

                    <button
                        className="pagination-button"
                        onClick={() => setCurrentPage(prev => Math.min(prev + 1, totalPages))}
                        disabled={currentPage === totalPages}
                    >
                        Sau
                    </button>
                </div>
            )}
        </div>
    );
};

export default TopicsPost; 