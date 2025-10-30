import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import './Deal.css';
import { ShoppingCart, Heart, Eye } from 'lucide-react';
import { useNavigate } from 'react-router-dom';

const Deal = () => {
    const [deals, setDeals] = useState([]);
    const [loading, setLoading] = useState(true);
    const [countdown, setCountdown] = useState(0);
    const [hoveredProduct, setHoveredProduct] = useState(null);
    const navigate = useNavigate();

    // Format price function
    const formatPrice = (price) => {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(price * 1);
    };

    useEffect(() => {
        const fetchDeals = async () => {
            try {
                setLoading(true);
                const response = await axios.get('http://localhost:8080/api/public/product-sales');
                console.log('Sales Response:', response.data);
                setDeals(response.data);
            } catch (error) {
                console.error('Failed to fetch deals:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchDeals();
    }, []);

    useEffect(() => {
        // 29 days in seconds
        const totalSeconds = 29 * 24 * 60 * 60; // 29 days
        setCountdown(totalSeconds);

        const interval = setInterval(() => {
            setCountdown(prevCountdown => {
                if (prevCountdown <= 0) {
                    clearInterval(interval);
                    return 0;
                }
                return prevCountdown - 1;
            });
        }, 1000);

        return () => clearInterval(interval);
    }, []);

    const formatTime = (seconds) => {
        const days = Math.floor(seconds / (24 * 60 * 60));
        const hours = Math.floor((seconds % (24 * 60 * 60)) / (60 * 60));
        const minutes = Math.floor((seconds % (60 * 60)) / 60);
        const secs = seconds % 60;
        return { days, hours, minutes, secs };
    };

    const { days, hours, minutes, secs } = formatTime(countdown);

    if (loading) {
        return (
            <div className="products-loading">
                <div className="loading-container">
                    <div className="loading-spinner"></div>
                    <p>Đang tải sản phẩm...</p>
                </div>
            </div>
        );
    }

    return (
        <section className="section-deals">
            <div className="container">
                <div className="deals-header">
                    <h3>DEALS AND OFFERS</h3>
                    <p>Sản phẩm đang giảm giá</p>
                    
                 
                </div>

                <div className="row">
                    {deals.length > 0 ? (
                        deals.map(deal => (
                            <div className="col-xl-3 col-lg-3 col-md-4 col-6" key={deal.id}>
                                <div 
                                    className="deal-card"
                                    onMouseEnter={() => setHoveredProduct(deal.id)}
                                    onMouseLeave={() => setHoveredProduct(null)}
                                >
                                    <div className="img-wrap">
                                        <img 
                                            src={`http://localhost:8080/api/public/products/image/${deal.productImage}`}
                                            alt={deal.productName}
                                        />
                                        <div className="discount-badge">
                                            -{deal.discount}%
                                        </div>
                                        
                                        {/* Quick Actions */}
                                        <div className={`quick-actions ${hoveredProduct === deal.id ? 'visible' : ''}`}>
                                            <button className="action-btn wishlist" title="Thêm vào yêu thích">
                                                <Heart size={18} />
                                            </button>
                                            <button 
                                                className="action-btn quick-view" 
                                                title="Xem nhanh"
                                                onClick={() => navigate(`/Detail/${deal.productId}`)}
                                            >
                                                <Eye size={18} />
                                            </button>
                                            <button className="action-btn add-cart" title="Thêm vào giỏ">
                                                <ShoppingCart size={18} />
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div className="card-body">
                                        <Link to={`/Detail/${deal.productId}`}>
                                            <h6 className="card-title">{deal.productName}</h6>
                                        </Link>
                                        <div className="price-wrap">
                                            <span className="price">{formatPrice(deal.salePrice)}</span>
                                            <span className="original-price">{formatPrice(deal.originalPrice)}</span>
                                        </div>
                                        <div className="sale-dates">
                                            <small>Sale: {new Date(deal.startDate).toLocaleDateString()} - {new Date(deal.endDate).toLocaleDateString()}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <div className="col-12">
                            <div className="no-deals">
                                <p>Không có sản phẩm giảm giá.</p>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </section>
    );
};

export default Deal;