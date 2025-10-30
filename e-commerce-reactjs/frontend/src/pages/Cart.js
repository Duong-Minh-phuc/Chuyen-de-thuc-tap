"use client"

import React, { useState, useEffect } from "react"
import { useNavigate } from "react-router-dom"
import { toast } from "react-hot-toast"
import Swal from "sweetalert2"
import "./Cart.css"

const Cart = () => {
  const navigate = useNavigate()
  const [cartItems, setCartItems] = useState([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    loadCartItems()
  }, [])

  const loadCartItems = () => {
    const savedCart = localStorage.getItem("cartItems")
    if (savedCart) {
      setCartItems(JSON.parse(savedCart))
    }
    setLoading(false)
  }

  const handleQuantityChange = (productId, newQuantity) => {
    if (newQuantity < 1) return

    const updatedCart = cartItems.map((item) => {
      if (item.id === productId) {
        return { ...item, quantity: newQuantity }
      }
      return item
    })

    setCartItems(updatedCart)
    localStorage.setItem("cartItems", JSON.stringify(updatedCart))

    const item = cartItems.find((item) => item.id === productId)
    if (item) {
      toast.success(`Đã cập nhật số lượng ${item.name} thành ${newQuantity}`, {
        style: {
          border: '1px solid #16a34a',
          padding: '16px',
          color: '#166534',
        },
        iconTheme: {
          primary: '#16a34a',
          secondary: '#FFFFFF',
        },
      })
    }
  }

  const handleRemoveItem = (productId) => {
    const itemToRemove = cartItems.find((item) => item.id === productId)

    Swal.fire({
      title: "Xác nhận xóa?",
      text: `Bạn có chắc chắn muốn xóa ${itemToRemove ? itemToRemove.name : "sản phẩm này"} khỏi giỏ hàng?`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#ef4444",
      cancelButtonColor: "#16a34a",
      confirmButtonText: "Xóa",
      cancelButtonText: "Hủy",
      background: '#ffffff',
      customClass: {
        popup: 'cart-swal-popup',
        title: 'cart-swal-title',
        content: 'cart-swal-content',
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const updatedCart = cartItems.filter((item) => item.id !== productId)
        setCartItems(updatedCart)
        localStorage.setItem("cartItems", JSON.stringify(updatedCart))

        toast.success(`Đã xóa ${itemToRemove ? itemToRemove.name : "sản phẩm"} khỏi giỏ hàng`, {
          style: {
            border: '1px solid #16a34a',
            padding: '16px',
            color: '#166534',
          },
          iconTheme: {
            primary: '#16a34a',
            secondary: '#FFFFFF',
          },
        })
      }
    })
  }

  const calculateSubtotal = () => {
    return cartItems.reduce((total, item) => total + item.price * item.quantity, 0)
  }

  const handleCheckout = () => {
    if (!localStorage.getItem("user_site")) {
      toast.error("Vui lòng đăng nhập để thanh toán", {
        style: {
          border: '1px solid #ef4444',
          padding: '16px',
          color: '#991b1b',
        },
      })
      navigate("/login")
      return
    }
    navigate("/checkout")
  }

  if (loading) {
    return (
      <div className="cart-loading">
        <div className="loading-spinner"></div>
        <p>Đang tải giỏ hàng...</p>
      </div>
    )
  }

  if (cartItems.length === 0) {
    return (
      <div className="cart-container">
        <div className="empty-cart">
          <div className="empty-cart-icon">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <circle cx="9" cy="21" r="1" />
              <circle cx="20" cy="21" r="1" />
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
            </svg>
          </div>
          <h2>Giỏ hàng trống</h2>
          <p>Hãy thêm sản phẩm vào giỏ hàng của bạn</p>
          <button className="continue-shopping-btn" onClick={() => navigate("/")}>
            Tiếp tục mua sắm
          </button>
        </div>
      </div>
    )
  }

  return (
    <div className="cart-container">
      <div className="cart-header">
        <h1>Giỏ hàng của bạn</h1>
        <p>{cartItems.length} sản phẩm trong giỏ hàng</p>
      </div>

      <div className="cart-content">
        <div className="cart-items">
          {cartItems.map((item) => (
            <div key={item.id} className="cart-item">
              <div className="item-image-container">
                <img
                  src={`http://127.0.0.1:8000/images/product/${item.thumbnail}`}
                  alt={item.name}
                  className="item-image"
                />
              </div>
              
              <div className="item-details">
                <div className="item-info">
                  <h3 className="item-name">{item.name}</h3>
                  <div className="item-price">
                    {new Intl.NumberFormat("vi-VN", {
                      style: "currency",
                      currency: "VND",
                    }).format(item.price)}
                  </div>
                </div>

                <div className="item-actions">
                  <div className="quantity-control">
                    <button
                      onClick={() => handleQuantityChange(item.id, item.quantity - 1)}
                      disabled={item.quantity <= 1}
                      className="quantity-btn"
                      aria-label="Giảm số lượng"
                    >
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="5" y1="12" x2="19" y2="12" strokeWidth="2" strokeLinecap="round" />
                      </svg>
                    </button>
                    <input
                      type="number"
                      value={item.quantity}
                      onChange={(e) => handleQuantityChange(item.id, parseInt(e.target.value))}
                      min="1"
                      className="quantity-input"
                      aria-label="Số lượng sản phẩm"
                    />
                    <button
                      onClick={() => handleQuantityChange(item.id, item.quantity + 1)}
                      className="quantity-btn"
                      aria-label="Tăng số lượng"
                    >
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="12" y1="5" x2="12" y2="19" strokeWidth="2" strokeLinecap="round" />
                        <line x1="5" y1="12" x2="19" y2="12" strokeWidth="2" strokeLinecap="round" />
                      </svg>
                    </button>
                  </div>

                  <button
                    onClick={() => handleRemoveItem(item.id)}
                    className="remove-btn"
                    aria-label="Xóa sản phẩm"
                  >
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                      <path d="M3 6h18" strokeWidth="2" strokeLinecap="round" />
                      <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2" strokeWidth="2" strokeLinecap="round" />
                    </svg>
                    <span>Xóa</span>
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>

        <div className="cart-summary">
          <div className="summary-content">
            <div className="summary-row">
              <span>Tạm tính</span>
              <span className="amount">
                {new Intl.NumberFormat("vi-VN", {
                  style: "currency",
                  currency: "VND",
                }).format(calculateSubtotal())}
              </span>
            </div>
            <div className="summary-row total">
              <span>Tổng cộng</span>
              <span className="amount">
                {new Intl.NumberFormat("vi-VN", {
                  style: "currency",
                  currency: "VND",
                }).format(calculateSubtotal())}
              </span>
            </div>
            <button onClick={handleCheckout} className="checkout-btn">
              Tiến hành thanh toán
            </button>
          </div>
        </div>
      </div>
    </div>
  )
}

export default Cart
