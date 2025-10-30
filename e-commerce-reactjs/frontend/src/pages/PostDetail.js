import React, { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import axios from 'axios';
import './PostDetail.css';
import { FaCalendarAlt, FaFolder, FaUser, FaClock } from 'react-icons/fa';

const PostDetail = () => {
    const [post, setPost] = useState(null);
    const [loading, setLoading] = useState(true);
    const { slug } = useParams();

    useEffect(() => {
        const fetchPostDetail = async () => {
            try {
                setLoading(true);
                const response = await axios.get(
                    `http://127.0.0.1:8000/api/post/detail/${slug}`
                );

                if (response.data.status) {
                    setPost(response.data.data);
                }
            } catch (error) {
                console.error('Error fetching post detail:', error);
            } finally {
                setLoading(false);
            }
        };

        if (slug) {
            fetchPostDetail();
        }
    }, [slug]);

    const formatDate = (dateString) => {
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return new Date(dateString).toLocaleDateString('vi-VN', options);
    };

    if (loading) {
        return (
            <div className="post-detail-loading">
                <div className="loading-spinner"></div>
                <p>Đang tải bài viết...</p>
            </div>
        );
    }

    if (!post) {
        return (
            <div className="post-detail-error">
                <h2>Không tìm thấy bài viết</h2>
                <Link to="/tin-tuc" className="back-to-blog">
                    Quay lại trang tin tức
                </Link>
            </div>
        );
    }

    return (
        <div className="post-detail-container">
            <div className="post-detail-header">
                <div className="post-breadcrumb">
                    <Link to="/">Trang chủ</Link>
                    <span className="separator">/</span>
                    <Link to="/tin-tuc">Tin tức</Link>
                    <span className="separator">/</span>
                    <span className="current">{post.title}</span>
                </div>

                <h1 className="post-detail-title">{post.title}</h1>

                <div className="post-detail-meta">
                    <div className="meta-item">
                        <FaUser />
                        <span>Admin</span>
                    </div>
                    <div className="meta-item">
                        <FaCalendarAlt />
                        <span>{formatDate(post.created_at)}</span>
                    </div>
                    <div className="meta-item">
                        <FaFolder />
                        <span>{post.type}</span>
                    </div>
                </div>
            </div>

            <div className="post-detail-content">
                <div className="post-detail-image">
                    <img
                        src={`http://127.0.0.1:8000/images/post/${post.thumbnail}`}
                        alt={post.title}
                        onError={(e) => {
                            e.target.src = "https://via.placeholder.com/1200x600?text=No+Image";
                        }}
                    />
                </div>

                <div className="post-detail-description">
                    <h2>Mô tả</h2>
                    <p>{post.description}</p>
                </div>

                <div className="post-detail-text">
                    <div dangerouslySetInnerHTML={{ __html: post.content }} />
                </div>
            </div>

            <div className="post-detail-footer">
                <div className="post-info">
                    <div className="info-item">
                        <strong>Ngày đăng:</strong> {formatDate(post.created_at)}
                    </div>
                    {post.updated_at && (
                        <div className="info-item">
                            <strong>Cập nhật:</strong> {formatDate(post.updated_at)}
                        </div>
                    )}
                </div>

                <Link to="/tin-tuc" className="back-to-blog">
                    ← Quay lại trang tin tức
                </Link>
            </div>
        </div>
    );
};

export default PostDetail; 