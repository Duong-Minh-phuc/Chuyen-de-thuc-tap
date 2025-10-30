import React, { useState, useEffect } from 'react';
import { Table, Button, Card, Form, InputGroup, Pagination, Modal } from 'react-bootstrap';
import { Link } from 'react-router-dom';
import { FaEdit, FaTrash, FaSearch, FaPlus, FaFileExcel, FaUpload } from 'react-icons/fa';
import axios from 'axios';

// Axios config
axios.defaults.baseURL = 'http://localhost:8080';

function ProductList() {
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');
    const [currentPage, setCurrentPage] = useState(0);
    const [pageSize] = useState(5); // Set fixed page size to 5
    const [totalPages, setTotalPages] = useState(0);
    const [totalElements, setTotalElements] = useState(0);
    const [error, setError] = useState('');
    const [exporting, setExporting] = useState(false);
    const [showImportModal, setShowImportModal] = useState(false);
    const [importFile, setImportFile] = useState(null);
    const [importing, setImporting] = useState(false);

    useEffect(() => {
        fetchProducts();
    }, [currentPage, pageSize]);

    const fetchProducts = async () => {
        try {
            setLoading(true);
            const response = await axios.get(`/api/public/products`, {
                params: {
                    pageNumber: currentPage + 1,
                    pageSize: pageSize,
                    sortBy: 'productId',
                    sortOrder: 'desc'
                }
            });
            setProducts(response.data.content);
            setTotalPages(response.data.totalPages);
            setTotalElements(response.data.totalElements);
            setError('');
        } catch (error) {
            console.error('Error fetching products:', error);
            setError('Không thể tải danh sách sản phẩm. Vui lòng thử lại.');
        } finally {
            setLoading(false);
        }
    };

    const handleSearch = async (e) => {
        e.preventDefault();
        if (!searchTerm.trim()) {
            fetchProducts();
            return;
        }

        try {
            setLoading(true);
            const response = await axios.get(`/api/public/products/keyword/${searchTerm}`, {
                params: {
                    pageNumber: currentPage + 1,
                    pageSize: pageSize,
                    sortBy: 'productId',
                    sortOrder: 'desc'
                }
            });
            setProducts(response.data.content);
            setTotalPages(response.data.totalPages);
            setTotalElements(response.data.totalElements);
            setError('');
        } catch (error) {
            console.error('Error searching products:', error);
            setError('Không thể tìm kiếm sản phẩm. Vui lòng thử lại.');
        } finally {
            setLoading(false);
        }
    };

    const handleDelete = async (productId) => {
        if (window.confirm('Are you sure you want to delete this product?')) {
            try {
                await axios.delete(`/api/admin/products/${productId}`);
                fetchProducts();
            } catch (error) {
                console.error('Error deleting product:', error);
                setError('Failed to delete product. Please try again.');
            }
        }
    };

    const handlePageChange = (pageNumber) => {
        setCurrentPage(pageNumber - 1);
    };

    const handleExportExcel = async () => {
        try {
            setExporting(true);
            const response = await axios.get('/api/admin/products/export-excel', {
                responseType: 'blob' // Important for handling file download
            });
            
            // Create a blob from the response data
            const blob = new Blob([response.data], { 
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            
            // Create a link element and trigger download
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'danh-sach-san-pham.xlsx');
            document.body.appendChild(link);
            link.click();
            
            // Cleanup
            window.URL.revokeObjectURL(url);
            document.body.removeChild(link);
        } catch (error) {
            console.error('Error exporting products:', error);
            setError('Không thể xuất file Excel. Vui lòng thử lại.');
        } finally {
            setExporting(false);
        }
    };

    const handleImportExcel = async () => {
        if (!importFile) {
            setError('Vui lòng chọn file Excel để import');
            return;
        }

        try {
            setImporting(true);
            const formData = new FormData();
            formData.append('file', importFile);

            await axios.post('/api/admin/products/import-excel', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });

            // Refresh the product list
            fetchProducts();
            setShowImportModal(false);
            setImportFile(null);
        } catch (error) {
            console.error('Error importing products:', error);
            setError('Không thể import file Excel. Vui lòng kiểm tra định dạng file và thử lại.');
        } finally {
            setImporting(false);
        }
    };

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            // Check if file is an Excel file
            if (!file.name.match(/\.(xlsx|xls)$/)) {
                setError('Vui lòng chọn file Excel (.xlsx hoặc .xls)');
                return;
            }
            setImportFile(file);
            setError('');
        }
    };

    if (loading) {
        return <div className="loading-spinner">Đang tải...</div>;
    }

    return (
        <div className="page-container">
            <div className="page-header">
                <h2 className="page-title">Sản phẩm</h2>
                <div className="d-flex gap-2">
                    <Button 
                        variant="success" 
                        className="d-flex align-items-center gap-2"
                        onClick={handleExportExcel}
                        disabled={exporting}
                    >
                        <FaFileExcel /> {exporting ? 'Đang xuất...' : 'Xuất Excel'}
                    </Button>
                    <Button 
                        variant="info" 
                        className="d-flex align-items-center gap-2"
                        onClick={() => setShowImportModal(true)}
                    >
                        <FaUpload /> Import Excel
                    </Button>
                    <Link to="/admin/products/create">
                        <Button variant="primary" className="d-flex align-items-center gap-2">
                            <FaPlus /> Thêm sản phẩm mới
                        </Button>
                    </Link>
                </div>
            </div>

            {/* Import Modal */}
            <Modal show={showImportModal} onHide={() => setShowImportModal(false)}>
                <Modal.Header closeButton>
                    <Modal.Title>Import Sản phẩm từ Excel</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <Form>
                        <Form.Group className="mb-3">
                            <Form.Label>Chọn file Excel</Form.Label>
                            <Form.Control
                                type="file"
                                accept=".xlsx,.xls"
                                onChange={handleFileChange}
                            />
                            <Form.Text className="text-muted">
                                Chỉ chấp nhận file Excel (.xlsx hoặc .xls)
                            </Form.Text>
                        </Form.Group>
                    </Form>
                    {error && <div className="alert alert-danger">{error}</div>}
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="secondary" onClick={() => setShowImportModal(false)}>
                        Hủy
                    </Button>
                    <Button 
                        variant="primary" 
                        onClick={handleImportExcel}
                        disabled={!importFile || importing}
                    >
                        {importing ? 'Đang import...' : 'Import'}
                    </Button>
                </Modal.Footer>
            </Modal>

            <Card className="search-card">
                <Card.Body>
                    <Form onSubmit={handleSearch}>
                        <InputGroup>
                            <Form.Control
                                placeholder="Tìm kiếm sản phẩm..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                className="search-input"
                            />
                            <Button variant="primary" type="submit">
                                <FaSearch className="me-2" /> Tìm kiếm
                            </Button>
                        </InputGroup>
                    </Form>
                </Card.Body>
            </Card>

            {error && <div className="alert alert-danger">{error}</div>}

            <Card className="table-container">
                <Card.Body>
                    <Table responsive hover className="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th style={{minWidth: '320px'}}>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Kho</th>
                                <th className="text-center">Đánh giá</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            {products.map(product => (
                                <tr key={product.productId}>
                                    <td>{product.productId}</td>
                                    <td>
                                        <div className="product-images">
                                            <img 
                                                src={`http://localhost:8080/api/public/products/image/${product.image}`}
                                                alt={product.productName}
                                                className="product-thumbnail"
                                            />
                                            {product.image1 && (
                                                <img 
                                                    src={`http://localhost:8080/api/public/products/image/${product.image1}`}
                                                    alt={`${product.productName} - 1`}
                                                    className="product-thumbnail"
                                                />
                                            )}
                                            {product.image2 && (
                                                <img 
                                                    src={`http://localhost:8080/api/public/products/image/${product.image2}`}
                                                    alt={`${product.productName} - 2`}
                                                    className="product-thumbnail"
                                                />
                                            )}
                                            {product.image3 && (
                                                <img 
                                                    src={`http://localhost:8080/api/public/products/image/${product.image3}`}
                                                    alt={`${product.productName} - 3`}
                                                    className="product-thumbnail"
                                                />
                                            )}
                                        </div>
                                    </td>
                                    <td>
                                        <div className="product-name">{product.productName}</div>
                                    </td>
                                    <td>
                                        <div className="category-name">{product.category?.name}</div>
                                    </td>
                                    <td>
                                        <div className="price-column">${product.price.toLocaleString()}</div>
                                    </td>
                                    <td>
                                        <span className={`stock-badge ${product.quantity > 0 ? 'stock-in' : 'stock-out'}`}>
                                            {product.quantity}
                                        </span>
                                    </td>
                                    <td className="text-center">
                                        <span className="badge bg-info">
                                            {product.totalReviews || 0}
                                        </span>
                                    </td>
                                    <td>
                                        <div className="action-buttons">
                                            <Link to={`/admin/products/edit/${product.productId}`}>
                                                <Button 
                                                    variant="outline-primary" 
                                                    className="btn-icon btn-edit"
                                                >
                                                    <FaEdit />
                                                </Button>
                                            </Link>
                                            <Button 
                                                variant="outline-danger"
                                                onClick={() => handleDelete(product.productId)}
                                                className="btn-icon btn-delete"
                                            >
                                                <FaTrash />
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </Table>

                    {totalPages > 1 && (
                        <div className="d-flex justify-content-center mt-4 mb-4">
                            <Pagination>
                                <Pagination.First 
                                    onClick={() => handlePageChange(1)}
                                    disabled={currentPage === 0}
                                />
                                <Pagination.Prev 
                                    onClick={() => handlePageChange(currentPage)}
                                    disabled={currentPage === 0}
                                />
                                
                                {[...Array(totalPages)].map((_, index) => (
                                    <Pagination.Item
                                        key={index + 1}
                                        active={currentPage === index}
                                        onClick={() => handlePageChange(index + 1)}
                                    >
                                        {index + 1}
                                    </Pagination.Item>
                                ))}

                                <Pagination.Next 
                                    onClick={() => handlePageChange(currentPage + 2)}
                                    disabled={currentPage === totalPages - 1}
                                />
                                <Pagination.Last 
                                    onClick={() => handlePageChange(totalPages)}
                                    disabled={currentPage === totalPages - 1}
                                />
                            </Pagination>
                        </div>
                    )}
                </Card.Body>
            </Card>
        </div>
    );
}

export default ProductList; 