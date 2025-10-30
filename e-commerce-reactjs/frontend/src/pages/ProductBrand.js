"use client"

import { useState, useEffect } from "react"
import "./ProductBrand.css"
import { Link, useParams } from "react-router-dom"
import { toast } from "react-hot-toast"
import axios from 'axios'
import Swal from 'sweetalert2'
import { useCart } from '../context/CartContext'

const ProductBrand = () => {
  const [products, setProducts] = useState([])
  const [loading, setLoading] = useState(true)
  const [currentPage, setCurrentPage] = useState(1)
  const [totalPages, setTotalPages] = useState(0)
  const [sortBy, setSortBy] = useState("default")
  const { slug } = useParams()
  const { addToCart } = useCart()

  useEffect(() => {
    if (slug) {
      fetchProducts();
    }
  }, [slug, currentPage]);

  const fetchProducts = async () => {
    try {
      setLoading(true);
      const response = await axios.get(`http://127.0.0.1:8000/api/product/brand/${slug}?page=${currentPage}`);
      
      if (response.data && response.data.status) {
        const productData = response.data.data.data;
        let sortedProducts = [...productData];
        
        if (sortBy === "price_asc") {
          sortedProducts.sort((a, b) => (a.price_sale || a.price_buy) - (b.price_sale || b.price_buy));
        } else if (sortBy === "price_desc") {
          sortedProducts.sort((a, b) => (b.price_sale || b.price_buy) - (a.price_sale || a.price_buy));
        }
        
        setProducts(sortedProducts);
        setTotalPages(response.data.data.last_page);
      } else {
        setProducts([]);
        setTotalPages(0);
      }
    } catch (error) {
      console.error('Error fetching products:', error);
      toast.error('Không thể tải sản phẩm. Vui lòng thử lại sau.');
      setProducts([]);
    } finally {
      setLoading(false);
    }
  };

  const handleSort = (value) => {
    setSortBy(value);
    let sortedProducts = [...products];
    
    switch(value) {
      case "price_asc":
        sortedProducts.sort((a, b) => (a.price_sale || a.price_buy) - (b.price_sale || b.price_buy));
        break;
      case "price_desc":
        sortedProducts.sort((a, b) => (b.price_sale || b.price_buy) - (a.price_sale || a.price_buy));
        break;
      default:
        break;
    }
    
    setProducts(sortedProducts);
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

  const formatPrice = (price) => {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    }).format(price)
  }

  if (loading) {
    return <div className="productlist-loading">Đang tải...</div>
  }

  return (
    <div className="products-container">
      <div className="products-header">
        <h1>Thương hiệu: {products[0]?.brand_name || ''}</h1>
        <div className="sort-container">
          <select 
            value={sortBy} 
            onChange={(e) => handleSort(e.target.value)}
            className="sort-select"
          >
            <option value="default">Sắp xếp theo</option>
            <option value="price_asc">Giá: Thấp đến Cao</option>
            <option value="price_desc">Giá: Cao đến Thấp</option>
          </select>
        </div>
      </div>

      <div className="productlist-grid">
        {products.map((product) => (
          <div key={product.id} className="productlist-card">
            <div className="productlist-image">
              <Link to={`/Detail/${product.slug}`}>
                <img
                  src={`http://127.0.0.1:8000/images/product/${product.thumbnail}`}
                  alt={product.name}
                  onError={(e) => {
                    e.target.src = "/placeholder.svg"
                  }}
                />
              </Link>
              {product.price_sale > 0 && (
                <span className="productlist-badge">
                  -{Math.round(((product.price_buy - product.price_sale) / product.price_buy) * 100)}%
                </span>
              )}
            </div>

            <div className="productlist-info">
              <h3>{product.name}</h3>
              <div className="productlist-brand">{product.brand_name}</div>
              <div className="productlist-price">
                {product.price_sale > 0 ? (
                  <>
                    <span className="productlist-sale-price">{formatPrice(product.price_sale)}</span>
                    <span className="productlist-original-price">{formatPrice(product.price_buy)}</span>
                  </>
                ) : (
                  <span className="productlist-regular-price">{formatPrice(product.price_buy)}</span>
                )}
              </div>
              <button 
                className="productlist-add-cart"
                onClick={() => handleAddToCart(product)}
                disabled={product.qty === 0}
              >
                {product.qty > 0 ? 'Thêm vào giỏ' : 'Hết hàng'}
              </button>
            </div>
          </div>
        ))}
      </div>

      {totalPages > 1 && (
        <div className="productlist-pagination">
          <button 
            onClick={() => setCurrentPage(prev => prev - 1)}
            disabled={currentPage === 1}
            className="productlist-page-button"
          >
            Trước
          </button>
          
          <span className="productlist-page-info">
            Trang {currentPage} / {totalPages}
          </span>
          
          <button 
            onClick={() => setCurrentPage(prev => prev + 1)}
            disabled={currentPage === totalPages}
            className="productlist-page-button"
          >
            Sau
          </button>
        </div>
      )}
    </div>
  )
}

export default ProductBrand 