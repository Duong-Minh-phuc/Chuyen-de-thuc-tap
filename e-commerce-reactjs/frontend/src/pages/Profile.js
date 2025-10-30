import React, { useState, useEffect } from 'react';
import { toast } from 'react-hot-toast';
import axios from 'axios';
import './Profile.css';

const Profile = () => {
    const [userData, setUserData] = useState(null);
    const [orderCount, setOrderCount] = useState(0);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const userSite = localStorage.getItem('user_site');
        if (userSite) {
            const parsedUser = JSON.parse(userSite);
            setUserData(parsedUser);
            fetchOrderCount(parsedUser.id);
        }
    }, []);

    const fetchOrderCount = async (userId) => {
        try {
            const response = await axios.get(`http://127.0.0.1:8000/api/order/user/${userId}`);
            if (response.data && response.data.data && response.data.data.data) {
                setOrderCount(response.data.data.data.length);
            }
            setLoading(false);
        } catch (error) {
            console.error('Error fetching order count:', error);
            toast.error('Không thể tải số lượng đơn hàng');
            setLoading(false);
        }
    };

    if (loading) return <div className="loading">Đang tải...</div>;

    return (
        <div className="profile-container">
            <div className="profile-header">
                <div className="profile-avatar">
                    {userData?.fullname?.charAt(0) || 'U'}
                </div>
                <h1>{userData?.fullname || 'Người dùng'}</h1>
            </div>

            <div className="profile-content">
                <div className="profile-card">
                    <h2>Thông tin cá nhân</h2>
                    <div className="info-item">
                        <span className="info-label">Email:</span>
                        <span className="info-value">{userData?.email || 'Chưa cập nhật'}</span>
                    </div>
                    <div className="info-item">
                        <span className="info-label">Số điện thoại:</span>
                        <span className="info-value">{userData?.phone || 'Chưa cập nhật'}</span>
                    </div>
                    <div className="info-item">
                        <span className="info-label">Vai trò:</span>
                        <span className="info-value">{userData?.roles || 'Khách hàng'}</span>
                    </div>
                    <div className="info-item">
                        <span className="info-label">Số đơn hàng:</span>
                        <span className="info-value highlight">{orderCount}</span>
                    </div>
                </div>

                <div className="profile-card">
                    <h2>Địa chỉ mặc định</h2>
                    <div className="address-content">
                        {userData?.address ? (
                            <p>{userData.address}</p>
                        ) : (
                            <p className="no-data">Chưa cập nhật địa chỉ</p>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Profile; 