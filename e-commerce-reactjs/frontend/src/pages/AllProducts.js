"use client"

import { useState, useEffect } from "react"
import "./ProductList.css"
import { Link } from "react-router-dom"
import { useParams } from "react-router-dom"
import { toast } from "react-hot-toast"
import Swal from 'sweetalert2'
import { useCart } from '../context/CartContext'

const ProductsPage = () => {
  const [products, setProducts] = useState([])
  const [loading, setLoading] = useState(true)
  const [currentPage, setCurrentPage] = useState(1)
  const [totalPages, setTotalPages] = useState(0)
  const [sortBy, setSortBy] = useState("default")
  const { product } = useParams()
  const [quantity, setQuantity] = useState(1)
  const { addToCart } = useCart()

  useEffect(() => {
    fetchProducts()
  }, [currentPage])

  const fetchProducts = async () => {
    try {
      setLoading(true)
      const response = await fetch(`http://127.0.0.1:8000/api/product?page=${currentPage}`)
      const data = await response.json()
      if (data && Array.isArray(data.data.data)) {
        let sortedProducts = [...data.data.data]
        
        // Sort products based on price
        if (sortBy === "price_asc") {
          sortedProducts.sort((a, b) => (a.price_sale || a.price_buy) - (b.price_sale || b.price_buy))
        } else if (sortBy === "price_desc") {
          sortedProducts.sort((a, b) => (b.price_sale || b.price_buy) - (a.price_sale || a.price_buy))
        }
        
        setProducts(sortedProducts)
        setTotalPages(data.data.last_page)
      }
    } catch (error) {
      console.error("Error:", error)
      setProducts([])
    } finally {
      setLoading(false)
    }
  }

  const handleSort = (value) => {
    setSortBy(value)
    const sortedProducts = [...products]
    if (value === "price_asc") {
      sortedProducts.sort((a, b) => (a.price_sale || a.price_buy) - (b.price_sale || b.price_buy))
    } else if (value === "price_desc") {
      sortedProducts.sort((a, b) => (b.price_sale || b.price_buy) - (a.price_sale || a.price_buy))
    }
    setProducts(sortedProducts)
  }

  const formatPrice = (price) => {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    }).format(price)
  }
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
    return <div className="productlist-loading">Đang tải...</div>
  }

  return (
    <div className="products-container">
      <div className="products-header">
        <h1>Tất Cả Sản Phẩm</h1>
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
            <Link to={`/Detail/${product.slug}`} className="product-image-link">
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
                  {Math.round(((product.price_buy - product.price_sale) / product.price_buy) * 100)}%
                </span>
              )}
            </div>
            
            <div className="productlist-info">
              <h3>{product.name}</h3>
              <div className="productlist-brand">{product.category_name}</div>
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

export default ProductsPage
