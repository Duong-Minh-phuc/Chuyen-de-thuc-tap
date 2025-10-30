import React, { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import axios from 'axios';
import './OrderDetail.css';
import { FaBox, FaUser, FaPhone, FaMapMarkerAlt, FaStickyNote, FaClock, FaEnvelope, FaEdit, FaSave, FaTimes } from 'react-icons/fa';
import { toast } from 'react-hot-toast';

const STATUS_PROCESSING = 1;    // Đang xử lý
const STATUS_CONFIRMED = 2;     // Đã xác nhận
const STATUS_DELIVERING = 4;    // Đang giao hàng
const STATUS_DELIVERED = 5;     // Đã giao hàng
const STATUS_CANCELLED = 7;     // Đã hủy

const getStatusText = (status) => {
    switch (status) {
        case STATUS_PROCESSING:
            return 'Đang xử lý';
        case STATUS_CONFIRMED:
            return 'Đã xác nhận';
        case STATUS_DELIVERING:
            return 'Đang giao hàng';
        case STATUS_DELIVERED:
            return 'Đã giao hàng';
        case STATUS_CANCELLED:
            return 'Đã hủy';
        default:
            return 'Không xác định';
    }
};

const getStatusClassName = (status) => {
    switch (status) {
        case STATUS_PROCESSING:
            return 'status-processing';
        case STATUS_CONFIRMED:
            return 'status-confirmed';
        case STATUS_DELIVERING:
            return 'status-delivering';
        case STATUS_DELIVERED:
            return 'status-delivered';
        case STATUS_CANCELLED:
            return 'status-cancelled';
        default:
            return '';
    }
};

const OrderDetail = () => {
    const [orderDetail, setOrderDetail] = useState(null);
    const [orderProducts, setOrderProducts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [isEditing, setIsEditing] = useState(false);
    const [editForm, setEditForm] = useState({
        fullname: '',
        email: '',
        phone: '',
        address: '',
        note: ''
    });
    const { orderId } = useParams();
    const navigate = useNavigate();

    useEffect(() => {
        fetchOrderDetail();
    }, [orderId]);

    const fetchOrderDetail = async () => {
        try {
            const response = await axios.get(
                `http://127.0.0.1:8000/api/order/show/${orderId}`
            );

            if (response.data && response.data.status) {
                const orderData = response.data.data;
                console.log('Order Data:', orderData);
                
                // Set order details from order object
                setOrderDetail({
                    order_id: orderData.order.id,
                    fullname: orderData.order.fullname,
                    email: orderData.order.email,
                    phone: orderData.order.phone,
                    address: orderData.order.address,
                    note: orderData.order.note,
                    created_at: orderData.order.created_at,
                    status: orderData.order.status
                });
                
                // Set products from order_details array
                if (orderData.order_details && Array.isArray(orderData.order_details)) {
                    setOrderProducts(orderData.order_details);
                }

                setEditForm({
                    fullname: orderData.order.fullname,
                    email: orderData.order.email || '',
                    phone: orderData.order.phone,
                    address: orderData.order.address,
                    note: orderData.order.note
                });
            }
        } catch (error) {
            console.error('Error fetching order detail:', error);
            toast.error('Could not load order details');
        } finally {
            setLoading(false);
        }
    };

    const handleEdit = () => {
        setIsEditing(true);
    };

    const handleCancel = () => {
        setIsEditing(false);
        setEditForm({
            fullname: orderDetail.fullname,
            email: orderDetail.email || '',
            phone: orderDetail.phone,
            address: orderDetail.address,
            note: orderDetail.note
        });
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setEditForm(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post(
                `http://127.0.0.1:8000/api/order/update/${orderId}`,
                editForm
            );

            if (response.data.status) {
                toast.success('Order updated successfully');
                setOrderDetail(prev => ({
                    ...prev,
                    ...editForm
                }));
                setIsEditing(false);
            } else {
                toast.error(response.data.message || 'Update failed');
            }
        } catch (error) {
            console.error('Error updating order:', error);
            toast.error('Failed to update order');
        }
    };

    const formatPrice = (price) => {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(price);
    };

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        
        return `${day}/${month}/${year} ${hours}:${minutes}`;
    };

    if (loading) {
        return (
            <div className="loading-container">
                <div className="loading-spinner"></div>
                <p>Loading order details...</p>
            </div>
        );
    }

    if (!orderDetail) {
        return (
            <div className="error-container">
                <p>Order not found</p>
                <button onClick={() => navigate('/orders')}>Back to Orders</button>
            </div>
        );
    }

    return (
        <div className="order-detail-container">
            <div className="order-header">
                <button className="back-button" onClick={() => navigate('/orders')}>
                    <FaBox /> Back to Orders
                </button>
                <div className="order-title">
                    <h1>Order #{orderDetail.order_id}</h1>
                    <div className="order-info">
                        <div className="order-date">
                            <FaClock /> {formatDate(orderDetail.created_at)}
                        </div>
                        <div className={`order-status ${getStatusClassName(orderDetail.status)}`}>
                            {getStatusText(orderDetail.status)}
                        </div>
                    </div>
                </div>
                {!isEditing ? (
                    <button className="edit-button" onClick={handleEdit}>
                        <FaEdit /> Edit Order
                    </button>
                ) : (
                    <div className="edit-actions">
                        <button className="save-button" onClick={handleSubmit}>
                            <FaSave /> Save
                        </button>
                        <button className="cancel-button" onClick={handleCancel}>
                            <FaTimes /> Cancel
                        </button>
                    </div>
                )}
            </div>

            <div className="order-content">
                <div className="customer-info">
                    {isEditing ? (
                        <form className="edit-form" onSubmit={handleSubmit}>
                            <div className="form-group">
                                <label>
                                    <FaUser className="form-icon" />
                                    Customer Name:
                                </label>
                                <input
                                    type="text"
                                    name="fullname"
                                    value={editForm.fullname}
                                    onChange={handleChange}
                                    required
                                />
                            </div>
                            <div className="form-group">
                                <label>
                                    <FaEnvelope className="form-icon" />
                                    Email:
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    value={editForm.email}
                                    onChange={handleChange}
                                    required
                                />
                            </div>
                            <div className="form-group">
                                <label>
                                    <FaPhone className="form-icon" />
                                    Phone:
                                </label>
                                <input
                                    type="tel"
                                    name="phone"
                                    value={editForm.phone}
                                    onChange={handleChange}
                                    required
                                />
                            </div>
                            <div className="form-group">
                                <label>
                                    <FaMapMarkerAlt className="form-icon" />
                                    Address:
                                </label>
                                <input
                                    type="text"
                                    name="address"
                                    value={editForm.address}
                                    onChange={handleChange}
                                    required
                                />
                            </div>
                            <div className="form-group">
                                <label>
                                    <FaStickyNote className="form-icon" />
                                    Note:
                                </label>
                                <textarea
                                    name="note"
                                    value={editForm.note}
                                    onChange={handleChange}
                                    rows="3"
                                />
                            </div>
                        </form>
                    ) : (
                        <>
                            <div className="info-row">
                                <FaUser className="info-icon" />
                                <div>
                                    <span className="label">Customer:</span>
                                    <span className="value">{orderDetail.fullname}</span>
                                </div>
                            </div>
                            <div className="info-row">
                                <FaEnvelope className="info-icon" />
                                <div>
                                    <span className="label">Email:</span>
                                    <span className="value">{orderDetail.email || 'N/A'}</span>
                                </div>
                            </div>
                            <div className="info-row">
                                <FaPhone className="info-icon" />
                                <div>
                                    <span className="label">Phone:</span>
                                    <span className="value">{orderDetail.phone}</span>
                                </div>
                            </div>
                            <div className="info-row">
                                <FaMapMarkerAlt className="info-icon" />
                                <div>
                                    <span className="label">Address:</span>
                                    <span className="value">{orderDetail.address}</span>
                                </div>
                            </div>
                            {orderDetail.note && (
                                <div className="info-row">
                                    <FaStickyNote className="info-icon" />
                                    <div>
                                        <span className="label">Note:</span>
                                        <span className="value">{orderDetail.note}</span>
                                    </div>
                                </div>
                            )}
                        </>
                    )}
                </div>

                <div className="product-info">
                    <h2 className="section-title">Order Products</h2>
                    {orderProducts && orderProducts.length > 0 ? (
                        orderProducts.map((product, index) => (
                            <div key={index} className="product-row">
                                <img 
                                    src={`http://127.0.0.1:8000/images/product/${product.thumbnail}`}
                                    alt={product.product_name}
                                    className="product-thumbnail"
                                />
                                <div className="product-details">
                                    <h3>{product.product_name}</h3>
                                    <div className="product-meta">
                                        <span>Quantity: {product.qty}</span>
                                        <span>Price: {formatPrice(product.price)}</span>
                                        <span>Total: {formatPrice(product.amount)}</span>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <p>No products found in this order</p>
                    )}
                </div>

                <div className="order-total">
                    <div className="total-row">
                        <span>Total Amount:</span>
                        <span className="amount">
                            {formatPrice(orderProducts.reduce((total, product) => total + product.amount, 0))}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default OrderDetail; 