import React, { useState, useEffect } from 'react';
import { useLocation, Link } from 'react-router-dom';
import axios from 'axios';
import './SearchResults.css';
import { useCart } from '../context/CartContext';
import { ShoppingCart } from 'lucide-react';
import Swal from 'sweetalert2';

const SearchResults = () => {
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const location = useLocation();
    const searchQuery = new URLSearchParams(location.search).get('q');
    const { addToCart } = useCart();

    useEffect(() => {
        const fetchSearchResults = async () => {
            try {
                setLoading(true);
                setError(null);
                
                if (!searchQuery) {
                    setProducts([]);
                    setLoading(false);
                    return;
                }

                const response = await axios.get(`http://127.0.0.1:8000/api/product/search/${encodeURIComponent(searchQuery)}`);
                
                if (response.data && response.data.status && response.data.data) {
                    setProducts(response.data.data.data || []);
                } else {
                    setProducts([]);
                }
            } catch (error) {
                console.error('Error fetching search results:', error);
                setError('Có lỗi xảy ra khi tìm kiếm. Vui lòng thử lại sau.');
                setProducts([]);
            } finally {
                setLoading(false);
            }
        };

        fetchSearchResults();
    }, [searchQuery]);

    const formatPrice = (price) => {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(price);
    };

    const handleAddToCart = (product) => {
        if (!product) return;

        addToCart(product, 1);
        
        Swal.fire({
            icon: 'success',
            title: 'Thêm vào giỏ hàng thành công!',
            text: `Đã thêm 1 ${product.name} vào giỏ hàng`,
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

    if (loading) {
        return <div className="loading">Đang tìm kiếm...</div>;
    }

    if (error) {
        return <div className="error-message">{error}</div>;
    }

    return (
        <div className="search-results-container">
            <div className="search-header">
                <h2>Kết quả tìm kiếm cho: "{searchQuery}"</h2>
                <p>Tìm thấy {products.length} sản phẩm</p>
            </div>

            <div className="products-grid">
                {products.length > 0 ? (
                    products.map(product => (
                        <div className="product-card" key={product.id}>
                            <div className="product-image-container">
                                <Link to={`/Detail/${product.slug}`} className="product-link">
                                    <img 
                                        src={`http://127.0.0.1:8000/images/product/${product.thumbnail}`}
                                        alt={product.name}
                                        className="product-image"
                                    />
                                    {product.price_sale > 0 && (
                                        <span className="discount-badge">
                                            -{Math.round(((product.price_buy - product.price_sale) / product.price_buy) * 100)}%
                                        </span>
                                    )}
                                </Link>
                            </div>
                            <div className="product-info">
                                <Link to={`/Detail/${product.slug}`} className="product-name-link">
                                    <h3 className="product-name">{product.name}</h3>
                                </Link>
                                <div className="product-meta">
                                    <span className="product-brand">{product.brand_name}</span>
                                    <span className="product-category">{product.category_name}</span>
                                </div>
                                <div className="product-price">
                                    <span className="current-price">
                                        {formatPrice(product.price_sale || product.price_buy)}
                                    </span>
                                    {product.price_sale > 0 && (
                                        <span className="original-price">
                                            {formatPrice(product.price_buy)}
                                        </span>
                                    )}
                                </div>
                                <button 
                                    className="add-to-cart-btn"
                                    onClick={() => handleAddToCart(product)}
                                    disabled={product.qty === 0}
                                >
                                    <ShoppingCart size={18} />
                                    {product.qty > 0 ? 'Thêm vào giỏ' : 'Hết hàng'}
                                </button>
                            </div>
                        </div>
                    ))
                ) : (
                    <div className="no-results">
                        <p>Không tìm thấy sản phẩm nào phù hợp với từ khóa "{searchQuery}"</p>
                        <p>Vui lòng thử lại với từ khóa khác</p>
                    </div>
                )}
            </div>
        </div>
    );
};

export default SearchResults; 