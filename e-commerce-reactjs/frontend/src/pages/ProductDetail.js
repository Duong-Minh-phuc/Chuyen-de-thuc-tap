"use client"

import React, { useEffect, useState } from 'react';
import { useParams, Link, useNavigate } from 'react-router-dom';
import { GET_ALL } from '../api/apiService';
import './ProductDetail.css';
import { useCart } from '../context/CartContext';
import axios from 'axios';
import { toast } from 'react-hot-toast';
import { FaStar } from 'react-icons/fa';
import Swal from 'sweetalert2';

const ProductDetail = () => {
    const [product, setProduct] = useState(null);
    const [loading, setLoading] = useState(true);
    const { slug } = useParams();
    const [quantity, setQuantity] = useState(1);
    const navigate = useNavigate();
    const [totalPrice, setTotalPrice] = useState(0);
    const { addToCart } = useCart();

    useEffect(() => {
        const fetchData = async () => {
            try {
                if (!slug) {
                    console.error('Slug is missing');
                    setLoading(false);
                    return;
                }

                const response = await axios.get(
                    `http://127.0.0.1:8000/api/product/detail/${slug}`
                );
                
                if (response.data && response.data.status) {
                    setProduct(response.data.data);
                    setTotalPrice(response.data.data.price_sale || response.data.data.price_buy);
                } else {
                    console.error('Không tìm thấy sản phẩm');
                }
            } catch (error) {
                console.error('Lỗi khi tải dữ liệu:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, [slug]);

    // Cập nhật tổng giá khi số lượng thay đổi
    useEffect(() => {
        if (product) {
            const price = product.price_sale || product.price_buy;
            setTotalPrice(price * quantity);
        }
    }, [quantity, product]);

    const handleIncrease = () => {
        if (quantity < product.qty) {
            setQuantity(prevQuantity => prevQuantity + 1);
        } else {
            toast.error('Số lượng đã đạt giới hạn tồn kho!');
        }
    };

    const handleDecrease = () => {
        if (quantity > 1) {
            setQuantity(prevQuantity => prevQuantity - 1);
        }
    };

    const handleAddToCart = () => {
        if (!product) return;

        addToCart(product, quantity);
        
        Swal.fire({
            icon: 'success',
            title: 'Thêm vào giỏ hàng thành công!',
            text: `Đã thêm ${quantity} ${product.name} vào giỏ hàng`,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#fff',
            iconColor: '#4CAF50',
            customClass: {
                popup: 'rounded-xl shadow-xl'
            }
        });
    };

    const StarRating = ({ rating }) => {
        return (
            <div className="star-display">
                {[...Array(5)].map((_, index) => (
                    <FaStar
                        key={index}
                        className="star"
                        color={index < Math.round(rating) ? "#ffc107" : "#e4e5e9"}
                        size={20}
                    />
                ))}
            </div>
        );
    };

    if (loading) return <div className="container mt-5">Đang tải...</div>;
    if (!product) return <div className="container mt-5">Không tìm thấy sản phẩm</div>;

    return (
        <div className="product-detail-wrapper">
            <div className="product-detail-container">
                <section className="product-detail-breadcrumb">
                    <div className="container">
                        <ol className="breadcrumb">
                            <li className="breadcrumb-item" style={{textDecoration: 'none'}}><Link to="/">Trang chủ</Link></li>
                            <li className="breadcrumb-item" style={{textDecoration: 'none'}}>
                                <Link to={`/category/${product.category_id}`}>
                                    {product.category_name}
                                </Link>
                            </li>
                            <li className="breadcrumb-item active">{product.name}</li>
                        </ol>
                    </div>
                </section>

                <section className="product-detail-content">
                    <div className="container">
                        <div className="row">
                            <aside className="col-md-6">
                                <div className="product-detail-gallery">
                                    <div className="product-detail-images">
                                        <div className="product-detail-img-wrap main-image">
                                            <img 
                                                src={`http://127.0.0.1:8000/images/product/${product.thumbnail}`}
                                                alt={product.name}
                                                className="detail-product-image"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </aside>

                            <main className="col-md-6">
                                <article className="product-detail-info">
                                    <h1 className="detail-product-title">{product.name}</h1>
                                    
                                    <div className="detail-price-info">
                                        <span className="detail-current-price">
                                            {new Intl.NumberFormat('vi-VN', { 
                                                style: 'currency', 
                                                currency: 'VND'
                                            }).format(product.price_sale || product.price_buy)}
                                        </span>
                                        {product.price_sale ===0&& (
                                            <span className="detail-original-price">
                                                
                                            </span>
                                            
                                        )}
                                    </div>

                                    <div className="product-meta">
                                        <div className="meta-row">
                                            <div className="meta-item">
                                                <span className="meta-label">Danh mục:</span>
                                                <span className="meta-value category">{product.category_name}</span>
                                            </div>
                                            <div className="meta-item">
                                                <span className="meta-label">Tình trạng:</span>
                                                <span className={`meta-value stock ${product.qty > 0 ? 'in-stock' : 'out-stock'}`}>
                                                    {product.qty > 0 ? `Còn ${product.qty}` : 'Hết hàng'}
                                                </span>
                                            </div>
                                            <div className="meta-item">
                                                <span className="meta-label">Lượt xem:</span>
                                                <span className="meta-value views">{product.view_count}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="detail-description">
                                        <h5>Mô tả sản phẩm</h5>
                                        <p>{product.content || 'Chưa có mô tả'}</p>
                                    </div>

                                    <div className="detail-actions">
                                        <div className="quantity-and-cart">
                                            <div className="detail-quantity-selector">
                                                <button 
                                                    className="btn-quantity"
                                                    onClick={handleDecrease}
                                                    disabled={quantity <= 1}
                                                >
                                                    -
                                                </button>
                                                <input 
                                                    type="number" 
                                                    className="quantity-input" 
                                                    value={quantity}
                                                    onChange={(e) => {
                                                        const value = parseInt(e.target.value);
                                                        if (value > 0 && value <= product.qty) {
                                                            setQuantity(value);
                                                        }
                                                    }}
                                                    min="1"
                                                    max={product.qty}
                                                />
                                                <button 
                                                    className="btn-quantity"
                                                    onClick={handleIncrease}
                                                    disabled={quantity >= product.qty}
                                                >
                                                    +
                                                </button>
                                            </div>

                                            <button 
                                                className={`detail-add-to-cart ${product.qty === 0 ? 'disabled' : ''}`}
                                                onClick={handleAddToCart}
                                                disabled={product.qty === 0}
                                            >
                                                <i className="fas fa-shopping-cart"></i>
                                                {product.qty > 0 ? 'Thêm vào giỏ hàng' : 'Hết hàng'}
                                            </button>
                                        </div>
                                    </div>
                                </article>
                            </main>
                        </div>
                    </div>
                </section>
            </div>

            <style jsx>{`
                .product-detail-wrapper {
                    padding: 20px 0;
                    background: #f8f9fa;
                }

                .product-detail-breadcrumb {
                    margin-bottom: 20px;
                }

                .detail-product-title {
                    font-size: 24px;
                    font-weight: 600;
                    margin-bottom: 20px;
                }

                .detail-price-info {
                    margin-bottom: 20px;
                }

                .detail-current-price {
                    font-size: 28px;
                    color: #e94560;
                    font-weight: 600;
                    margin-right: 10px;
                }

                .detail-original-price {
                    font-size: 20px;
                    color: #999;
                    text-decoration: line-through;
                }

                .product-meta {
                    margin: 20px 0;
                    padding: 15px;
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                }

                .meta-row {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                }

                .meta-item {
                    display: flex;
                    align-items: center;
                    padding: 8px 0;
                }

                .meta-label {
                    font-size: 14px;
                    font-weight: 600;
                    color: #333;
                    width: 100px;
                }

                .meta-value {
                    font-size: 14px;
                    margin-left: 10px;
                }

                .meta-value.category,
                .meta-value.in-stock,
                .meta-value.out-stock,
                .meta-value.views {
                    background: none;
                    padding: 0;
                    color: #333;
                }

                @media (max-width: 768px) {
                    .meta-row {
                        flex-direction: column;
                    }
                    
                    .meta-item {
                        width: 100%;
                    }
                }

                .detail-description {
                    margin: 20px 0;
                    padding: 15px;
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                }

                .quantity-and-cart {
                    display: flex;
                    gap: 15px;
                    align-items: center;
                    margin-top: 20px;
                }

                .detail-quantity-selector {
                    display: flex;
                    align-items: center;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    overflow: hidden;
                }

                .btn-quantity {
                    padding: 8px 15px;
                    border: none;
                    background: #f8f9fa;
                    cursor: pointer;
                    font-size: 16px;
                }

                .btn-quantity:disabled {
                    opacity: 0.5;
                    cursor: not-allowed;
                }

                .quantity-input {
                    width: 60px;
                    text-align: center;
                    border: none;
                    border-left: 1px solid #ddd;
                    border-right: 1px solid #ddd;
                    padding: 8px;
                }

                .detail-add-to-cart {
                    flex: 1;
                    padding: 12px 25px;
                    border: none;
                    background: #e94560;
                    color: white;
                    border-radius: 4px;
                    cursor: pointer;
                    font-weight: 600;
                    transition: all 0.3s ease;
                }

                .detail-add-to-cart:hover {
                    background: #d63384;
                }

                .detail-add-to-cart.disabled {
                    background: #999;
                    cursor: not-allowed;
                }

                .detail-product-image {
                    width: 100%;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
            `}</style>
        </div>
    );
};

export default ProductDetail;

