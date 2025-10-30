"use client"

import { useEffect, useState } from "react"
import { Link } from "react-router-dom"
import axios from "axios"
import "./Seeds.css"
import { ShoppingCart } from "lucide-react"
import Swal from 'sweetalert2'
import { useCart } from '../../context/CartContext'

const Seed = () => {
  const [seeds, setSeeds] = useState([])
  const [loading, setLoading] = useState(true)
  const { addToCart } = useCart()

  // Format price function
  const formatPrice = (price) => {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    }).format(price)
  }

  useEffect(() => {
    const fetchSeeds = async () => {
      try {
        setLoading(true)
        const response = await axios.get(
          "http://127.0.0.1:8000/api/product/sale"
        )
        if (response.data && response.data.data && response.data.data.data) {
          setSeeds(response.data.data.data)
        }
      } catch (error) {
        console.error("Failed to fetch seeds:", error)
      } finally {
        setLoading(false)
      }
    }

    fetchSeeds()
  }, [])

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
    return (
      <div className="seeds-loading">
        <div className="loading-container">
          <div className="loading-spinner"></div>
          <p>Đang tải sản phẩm...</p>
        </div>
      </div>
    )
  }

  return (
    <section className="featured-seeds">
      <div className="container">
        <div className="seeds-header">
          <h2>Hạt giống đang được giảm giá</h2>
          <p>Cũng là Hạt giống bán chạy nhất mà người trồng yêu thích</p>
        </div>

        <div className="seeds-grid">
          {seeds.length > 0 ? (
            seeds.map((seed) => (
              <div className="seed-card" key={seed.id}>
                <Link to={`/Detail/${seed.slug}`} className="seed-image-container">
                  <img
                    src={`http://127.0.0.1:8000/images/product/${seed.thumbnail}`}
                    alt={seed.name}
                    className="seed-image"
                  />
                  {seed.price_sale > 0 && (
                    <div className="discount-badge">
                      -{Math.round(((seed.price_buy - seed.price_sale) / seed.price_buy) * 100)}%
                    </div>
                  )}
                </Link>

                <div className="seed-info">
                  <Link to={`/Detail/${seed.slug}`} className="seed-name-link">
                    <h3 className="seed-name">{seed.name}</h3>
                  </Link>
                  <div className="seed-price">
                    {seed.price_sale > 0 ? (
                      <>
                        <span className="sale-price">{formatPrice(seed.price_sale)}</span>
                        <span className="original-price">{formatPrice(seed.price_buy)}</span>
                      </>
                    ) : (
                      <span className="regular-price">{formatPrice(seed.price_buy)}</span>
                    )}
                  </div>
                  <button 
                    className="add-to-cart" 
                    onClick={() => handleAddToCart(seed)}
                    disabled={seed.qty === 0}
                  >
                    <ShoppingCart size={18} />
                    {seed.qty > 0 ? "Add to Cart" : "Hết hàng"}
                  </button>
                </div>
              </div>
            ))
          ) : (
            <div className="no-seeds">
              <p>Không có sản phẩm.</p>
            </div>
          )}
        </div>

        <div className="view-all-container">
          <Link to="/products" className="view-all-button">
            View All Products
          </Link>
        </div>
      </div>
    </section>
  )
}

export default Seed 