import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { FaBox, FaShoppingBag, FaDollarSign } from 'react-icons/fa';

function Dashboard() {
    const [stats, setStats] = useState({
        totalProducts: 0,
        totalOrders: 0,
        totalRevenue: 0,
        recentOrders: []
    });

    useEffect(() => {
        // In a real application, you would fetch this data from your API
        const fetchDashboardData = async () => {
            try {
                // Mock data for demonstration
                setStats({
                    totalProducts: 42,
                    totalOrders: 156,
                    totalRevenue: 12500,
                    recentOrders: [
                        { id: 1, customer: 'Nguyễn Văn A', date: '2024-02-08', amount: 1560000, status: 'Completed' },
                        { id: 2, customer: 'Trần Thị B', date: '2024-02-08', amount: 2400000, status: 'Processing' },
                        { id: 3, customer: 'Lê Văn C', date: '2024-02-07', amount: 890000, status: 'Shipped' },
                        { id: 4, customer: 'Phạm Thị D', date: '2024-02-07', amount: 1200000, status: 'Completed' },
                        { id: 5, customer: 'Hoàng Văn E', date: '2024-02-06', amount: 3500000, status: 'Processing' }
                    ]
                });
            } catch (error) {
                console.error('Error fetching dashboard data:', error);
            }
        };

        fetchDashboardData();
    }, []);

    return (
        <div>
            <h2 style={{ color: '#e5e7eb', marginBottom: '2rem' }}>Dashboard</h2>
            
            <div className="dashboard-stats">
                <div className="stat-card products">
                    <h3>Tổng sản phẩm</h3>
                    <div className="value">{stats.totalProducts}</div>
                    <FaBox className="icon" />
                </div>
                <div className="stat-card orders">
                    <h3>Tổng đơn hàng</h3>
                    <div className="value">{stats.totalOrders}</div>
                    <FaShoppingBag className="icon" />
                </div>
                <div className="stat-card revenue">
                    <h3>Doanh thu</h3>
                    <div className="value">
                        {stats.totalRevenue.toLocaleString('vi-VN')}đ
                    </div>
                    <FaDollarSign className="icon" />
                </div>
            </div>
            
            <div className="table-container">
                <h3>Đơn hàng gần đây</h3>
                <table className="admin-table">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        {stats.recentOrders.map(order => (
                            <tr key={order.id}>
                                <td>#{order.id}</td>
                                <td>{order.customer}</td>
                                <td>{new Date(order.date).toLocaleDateString('vi-VN')}</td>
                                <td>{order.amount.toLocaleString('vi-VN')}đ</td>
                                <td>
                                    <span className={`status-badge status-${order.status.toLowerCase()}`}>
                                        {order.status === 'Completed' ? 'Hoàn thành' :
                                         order.status === 'Processing' ? 'Đang xử lý' :
                                         order.status === 'Shipped' ? 'Đang giao' : order.status}
                                    </span>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
}

export default Dashboard; 