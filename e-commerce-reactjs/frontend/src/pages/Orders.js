import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import { toast } from 'react-hot-toast';
import './Orders.css';
import { FaBox, FaMapMarkerAlt, FaPhone, FaStickyNote, FaClock, FaUser, FaEye } from 'react-icons/fa';

const Orders = () => {
    const [orders, setOrders] = useState([]);
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();

    const fetchOrders = async () => {
        try {
            const userStr = localStorage.getItem('user_site');
            if (!userStr) {
                navigate('/login');
                return;
            }

            const user = JSON.parse(userStr);
            const response = await axios.get(
                `http://127.0.0.1:8000/api/order/user/${user.id}`
            );

            if (response.data && response.data.status) {
                setOrders(response.data.data.data || []);
            }
        } catch (error) {
            console.error('Error fetching orders:', error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchOrders();
    }, [navigate]);

    const getStatusLabel = (status) => {
        switch (status) {
            case 1:
                return { text: 'Đang xử lý', color: '#f97316', bgColor: '#fff7ed' };
            case 2:
                return { text: 'Đã xác nhận', color: '#059669', bgColor: '#ecfdf5' };
            case 4:
                return { text: 'Đang giao hàng', color: '#2563eb', bgColor: '#eff6ff' };
            case 5:
                return { text: 'Đã giao hàng', color: '#16a34a', bgColor: '#f0fdf4' };
            case 7:
                return { text: 'Đã hủy', color: '#dc2626', bgColor: '#fef2f2' };
            default:
                return { text: 'Không xác định', color: '#6b7280', bgColor: '#f9fafb' };
        }
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

    const handleViewDetails = (orderId) => {
        navigate(`/orders/${orderId}`);
    };

    if (loading) {
        return (
            <div style={{ 
                display: 'flex', 
                justifyContent: 'center', 
                alignItems: 'center', 
                height: '200px',
                fontSize: '18px',
                color: '#6b7280'
            }}>
                <div className="loading-spinner"></div>
                Loading orders...
            </div>
        );
    }

    return (
        <div style={{ 
            padding: '40px', 
            maxWidth: '1200px', 
            margin: '0 auto' 
        }}>
            <h2 style={{ 
                marginBottom: '30px', 
                fontSize: '28px', 
                fontWeight: 'bold',
                color: '#333',
                display: 'flex',
                alignItems: 'center',
                gap: '12px'
            }}>
                <FaBox style={{ color: '#4f46e5' }} />
                My Orders
            </h2>

            {orders.length === 0 ? (
                <div style={{
                    textAlign: 'center',
                    padding: '40px',
                    backgroundColor: '#f9fafb',
                    borderRadius: '12px',
                    border: '2px dashed #e5e7eb'
                }}>
                    <FaBox style={{ fontSize: '48px', color: '#9ca3af', marginBottom: '16px' }} />
                    <p style={{ color: '#4b5563', fontSize: '16px' }}>No orders found</p>
                </div>
            ) : (
                <div style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
                    {orders.map((order) => (
                        <div
                            key={order.id}
                            style={{
                                backgroundColor: '#fff',
                                borderRadius: '12px',
                                padding: '24px',
                                boxShadow: '0 1px 3px rgba(0, 0, 0, 0.1)',
                                border: '1px solid #e5e7eb',
                                transition: 'transform 0.2s ease-in-out',
                            }}
                        >
                            <div style={{ 
                                display: 'flex', 
                                justifyContent: 'space-between', 
                                alignItems: 'center',
                                marginBottom: '20px',
                                padding: '0 0 20px',
                                borderBottom: '1px solid #e5e7eb'
                            }}>
                                <div>
                                    <div style={{ 
                                        display: 'flex', 
                                        alignItems: 'center', 
                                        gap: '8px',
                                        marginBottom: '8px'
                                    }}>
                                        <FaBox style={{ color: '#4f46e5' }} />
                                        <p style={{ 
                                            fontSize: '20px', 
                                            fontWeight: 'bold', 
                                            color: '#111827'
                                        }}>
                                            Order #{order.id}
                                        </p>
                                    </div>
                                    <div style={{ 
                                        display: 'flex', 
                                        alignItems: 'center', 
                                        gap: '8px',
                                        color: '#6b7280'
                                    }}>
                                        <FaClock size={14} />
                                        <p style={{ fontSize: '14px' }}>
                                            {formatDate(order.created_at)}
                                        </p>
                                    </div>
                                </div>
                                <div style={{
                                    padding: '8px 16px',
                                    borderRadius: '9999px',
                                    backgroundColor: getStatusLabel(order.status).bgColor,
                                    color: getStatusLabel(order.status).color,
                                    fontWeight: '500',
                                    fontSize: '14px',
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: '6px'
                                }}>
                                    <span className="status-dot" style={{ 
                                        backgroundColor: getStatusLabel(order.status).color 
                                    }}></span>
                                    {getStatusLabel(order.status).text}
                                </div>
                            </div>

                            <div style={{ 
                                display: 'flex', 
                                flexDirection: 'column', 
                                gap: '12px'
                            }}>
                                <div style={{ 
                                    display: 'flex', 
                                    alignItems: 'center', 
                                    gap: '8px',
                                    color: '#374151'
                                }}>
                                    <FaUser style={{ color: '#6b7280' }} />
                                    <strong>Customer:</strong> {order.fullname}
                                </div>
                                <div style={{ 
                                    display: 'flex', 
                                    alignItems: 'center', 
                                    gap: '8px',
                                    color: '#374151'
                                }}>
                                    <FaMapMarkerAlt style={{ color: '#6b7280' }} />
                                    <strong>Delivery Address:</strong> {order.address}
                                </div>
                                <div style={{ 
                                    display: 'flex', 
                                    alignItems: 'center', 
                                    gap: '8px',
                                    color: '#374151'
                                }}>
                                    <FaPhone style={{ color: '#6b7280' }} />
                                    <strong>Phone:</strong> {order.phone}
                                </div>
                                {order.note && (
                                    <div style={{ 
                                        display: 'flex', 
                                        alignItems: 'center', 
                                        gap: '8px',
                                        color: '#374151'
                                    }}>
                                        <FaStickyNote style={{ color: '#6b7280' }} />
                                        <strong>Note:</strong> {order.note}
                                    </div>
                                )}
                            </div>

                            <button
                                onClick={() => handleViewDetails(order.id)}
                                style={{
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    gap: '8px',
                                    width: '100%',
                                    marginTop: '20px',
                                    padding: '12px',
                                    backgroundColor: '#4f46e5',
                                    color: 'white',
                                    border: 'none',
                                    borderRadius: '8px',
                                    fontWeight: '500',
                                    cursor: 'pointer',
                                    transition: 'background-color 0.2s ease',
                                }}
                                onMouseOver={(e) => e.target.style.backgroundColor = '#4338ca'}
                                onMouseOut={(e) => e.target.style.backgroundColor = '#4f46e5'}
                            >
                                <FaEye />
                                View Details
                            </button>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
};

export default Orders;