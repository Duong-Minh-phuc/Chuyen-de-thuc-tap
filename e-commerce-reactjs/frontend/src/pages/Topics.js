import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import './Topics.css';
import { FaNewspaper } from 'react-icons/fa';

const Topics = () => {
    const [topics, setTopics] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchTopics = async () => {
            try {
                setLoading(true);
                const response = await axios.get(
                    'http://127.0.0.1:8000/api/topic'
                );

                if (response.data.status) {
                    setTopics(response.data.data.data);
                }
            } catch (error) {
                console.error('Lỗi khi tải chủ đề:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchTopics();
    }, []);

    if (loading) {
        return (
            <div className="topics-loading">
                <div className="loading-spinner"></div>
                <p>Đang tải chủ đề...</p>
            </div>
        );
    }

    return (
        <div className="topics-container">
            <div className="topics-header">
                <h1>Chủ đề bài viết</h1>
                <p>Khám phá các bài viết theo từng chủ đề yêu thích của bạn</p>
            </div>

            <div className="topics-grid">
                {topics.map((topic) => (
                    <Link
                        to={`/chu-de-bai-viet/${topic.slug}`}
                        key={topic.id}
                        className="topic-card"
                    >
                        <div className="topic-icon">
                            <FaNewspaper />
                        </div>
                        <h2>{topic.name}</h2>
                        <p>{topic.description}</p>
                        <span className="view-posts">Xem bài viết</span>
                    </Link>
                ))}
            </div>
        </div>
    );
};

export default Topics; 