"use client"

import { useEffect, useState } from "react"
import { Link } from "react-router-dom"
import { useNavigate } from "react-router-dom"
import axios from "axios"
import Swal from "sweetalert2"
import { useCart } from "../../context/CartContext"
import "./Section1.css"

// Tạo instance axios với cấu hình mặc định
const api = axios.create({
  baseURL: "http://127.0.0.1:8000",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
  withCredentials: true, // Thêm option này để gửi cookies nếu cần
})

const Section1 = () => {
  const [categories, setCategories] = useState([])
  const [saleProducts, setSaleProducts] = useState([])
  const [newProducts, setNewProducts] = useState([])
  const [loading, setLoading] = useState(true)
  const [hoveredProduct, setHoveredProduct] = useState(null)
  const [cartItems, setCartItems] = useState(() => {
    const savedCart = localStorage.getItem("cartItems")
    return savedCart ? JSON.parse(savedCart) : []
  })
  const navigate = useNavigate()
  const { addToCart } = useCart()

  useEffect(() => {
    setLoading(true)
    axios
      .get("http://127.0.0.1:8000/api/category")
      .then((response) => {
        if (response.data && Array.isArray(response.data.data.data)) {
          setCategories(response.data.data.data)
        } else {
          console.error("Dữ liệu trả về không chứa mảng danh mục:", response.data)
          setCategories([])
        }
      })
      .catch((error) => {
        console.error("Có lỗi xảy ra khi lấy danh mục!", error)
        setCategories([])
      })
      .finally(() => {
        setLoading(false)
      })

    // Gọi API sản phẩm khuyến mãi
    axios
      .get("http://127.0.0.1:8000/api/product/sale")
      .then((response) => {
        if (response.data && Array.isArray(response.data.data.data)) {
          setSaleProducts(response.data.data.data)
        } else {
          console.error("Dữ liệu trả về không chứa mảng sản phẩm:", response.data)
          setSaleProducts([])
        }
      })
      .catch((error) => {
        console.error("Có lỗi xảy ra khi lấy sản phẩm khuyến mãi!", error)
        setSaleProducts([])
      })

    axios
      .get("http://127.0.0.1:8000/api/product/new")
      .then((response) => {
        if (response.data && Array.isArray(response.data.data.data)) {
          setNewProducts(response.data.data.data)
        } else {
          console.error("Dữ liệu trả về không chứa mảng sản phẩm:", response.data)
          setNewProducts([])
        }
      })
      .catch((error) => {
        console.error("Có lỗi xảy ra khi lấy sản phẩm khuyến mãi!", error)
        setNewProducts([])
      })
      .finally(() => {
        setLoading(false)
      })
  }, [])

  const formatPrice = (price) => {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    }).format(price)
  }

  const renderStars = (averageRating = 5) => {
    const stars = []
    const fullStars = Math.floor(averageRating)
    const hasHalfStar = averageRating % 1 !== 0

    for (let i = 0; i < 5; i++) {
      if (i < fullStars) {
        stars.push(
          <svg
            key={i}
            className="star filled"
            width="14"
            height="14"
            viewBox="0 0 24 24"
            fill="currentColor"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
          </svg>,
        )
      } else if (i === fullStars && hasHalfStar) {
        stars.push(
          <svg
            key={i}
            className="star half"
            width="14"
            height="14"
            viewBox="0 0 24 24"
            fill="currentColor"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
          </svg>,
        )
      } else {
        stars.push(
          <svg
            key={i}
            className="star empty"
            width="14"
            height="14"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
          </svg>,
        )
      }
    }
    return stars
  }

  const handleAddToCart = (product) => {
    if (!product) return

    addToCart(product, 1)

    Swal.fire({
      icon: "success",
      title: "Thêm vào giỏ hàng thành công!",
      text: `Đã thêm 1 ${product.name} vào giỏ hàng`,
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      background: "#fff",
      iconColor: "#16a34a",
      customClass: {
        popup: "rounded-xl shadow-xl",
      },
    })
  }

  if (loading) {
    return (
      <div className="featured-loading">
        <div className="loading-container">
          <div className="loading-spinner"></div>
          <p>Đang tải danh mục...</p>
        </div>
      </div>
    )
  }

  return (
    <div className="featured-section">
      <div className="featured-container">
        {/* Header */}
        <div className="featured-header">
          <h2 className="featured-title">Danh Mục Sản Phẩm</h2>
          <p className="featured-subtitle">Khám phá các danh mục hạt giống của GreenSprout</p>
        </div>

        {/* Categories Grid */}
        <div className="featured-grid">
          {categories.length > 0 ? (
            categories.map((category) => (
              <Link to={`/danh-muc/${category.slug}`} key={category.id} className="featured-card">
                <div className="featured-image-container">
                  <img
                    src={`http://127.0.0.1:8000/images/category/${category.image}`}
                    alt={category.name}
                    className="featured-image"
                  />
                </div>
                <div className="featured-content">
                  <h3 className="featured-name">{category.name}</h3>
                </div>
              </Link>
            ))
          ) : (
            <div className="featured-empty">
              <div className="featured-empty-content">
                <h3>Không có danh mục</h3>
                <p>Hiện tại chưa có danh mục nào.</p>
              </div>
            </div>
          )}
        </div>

        {/* View All Button */}
        {categories.length > 0 && (
          <div className="featured-footer">
            <Link to="/categories" className="featured-view-all">
              Xem Tất Cả Danh Mục
            </Link>
          </div>
        )}
      </div>
    </div>
  )
}

export default Section1
