import React, { useState, useEffect } from 'react';
import { Table, Button, Card, Alert } from 'react-bootstrap';
import { Link } from 'react-router-dom';
import { FaEdit, FaTrash, FaPlus } from 'react-icons/fa';
import axios from 'axios';

function ProductSaleList() {
    const [sales, setSales] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        fetchSales();
    }, []);

    const fetchSales = async () => {
        try {
            const response = await axios.get('http://localhost:8080/api/public/product-sales');
            setSales(response.data);
            setLoading(false);
        } catch (error) {
            console.error('Error fetching sales:', error);
            setError('Không thể tải danh sách khuyến mãi. Vui lòng thử lại.');
            setLoading(false);
        }
    };

    const handleDelete = async (saleId) => {
        if (window.confirm('Bạn có chắc chắn muốn xóa khuyến mãi này?')) {
            try {
                await axios.delete(`http://localhost:8080/api/admin/product-sales/${saleId}`);
                fetchSales();
            } catch (error) {
                console.error('Error deleting sale:', error);
                setError('Không thể xóa khuyến mãi. Vui lòng thử lại.');
            }
        }
    };

    const formatDate = (dateString) => {
        return new Date(dateString).toLocaleDateString('vi-VN', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    if (loading) {
        return <div className="loading-spinner">Đang tải...</div>;
    }

    return (
        <div className="page-container">
            <div className="page-header">
                <h2 className="page-title">Khuyến mãi sản phẩm</h2>
                <Link to="/admin/product-sales/create">
                    <Button variant="primary" className="d-flex align-items-center gap-2">
                        <FaPlus /> Thêm khuyến mãi mới
                    </Button>
                </Link>
            </div>

            {error && <Alert variant="danger">{error}</Alert>}

            <div className="table-container">
                <Table responsive hover className="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style={{minWidth: '320px'}}>Sản phẩm</th>
                            <th>Giá gốc</th>
                            <th>Giảm giá</th>
                            <th>Giá sale</th>
                            <th>Thời gian</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        {sales.map(sale => (
                            <tr key={sale.id}>
                                <td>{sale.id}</td>
                                <td>
                                    <div className="d-flex align-items-center gap-3">
                                        <div className="product-images">
                                            <img 
                                                src={`http://localhost:8080/api/public/products/image/${sale.productImage}`}
                                                alt={sale.productName}
                                                className="product-thumbnail"
                                            />
                                        </div>
                                        <div className="product-name">{sale.productName}</div>
                                    </div>
                                </td>
                                <td>
                                    <div className="price-column">{sale.originalPrice.toLocaleString()}đ</div>
                                </td>
                                <td>
                                    <div className="discount-column text-center">
                                        {sale.discount !== undefined && sale.discount !== null ? sale.discount + '%' : '-'}
                                    </div>
  </td>
                                <td>
                                    <div className="price-column sale-price">{sale.salePrice.toLocaleString()}đ</div>
                                </td>
                                <td>
                                    <div className="sale-duration">
                                        <div>Từ: {formatDate(sale.startDate)}</div>
                                        <div>Đến: {formatDate(sale.endDate)}</div>
                                    </div>
                                </td>
                                <td>
                                    <span className={`status-badge ${sale.active ? 'status-active' : 'status-inactive'}`}>
                                        {sale.active ? 'Đang diễn ra' : 'Kết thúc'}
                                    </span>
                                </td>
                                <td>
                                    <div className="action-buttons">
                                        <Link to={`/admin/product-sales/edit/${sale.id}`}>
                                            <Button 
                                                variant="outline-primary" 
                                                className="btn-icon btn-edit"
                                            >
                                                <FaEdit />
                                            </Button>
                                        </Link>
                                        <Button 
                                            variant="outline-danger"
                                            onClick={() => handleDelete(sale.id)}
                                            className="btn-icon btn-delete"
                                        >
                                            <FaTrash />
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                        ))}
                        {sales.length === 0 && (
                            <tr>
                                <td colSpan="8" className="text-center">Chưa có khuyến mãi nào</td>
                            </tr>
                        )}
                    </tbody>
                </Table>
            </div>
        </div>
    );
}

export default ProductSaleList; 