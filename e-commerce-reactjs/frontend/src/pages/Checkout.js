import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import Swal from 'sweetalert2';
import './Checkout.css';

function Checkout() {
  const [isProcessing, setIsProcessing] = useState(false);
  const [orderDetails, setOrderDetails] = useState({
    phone: '',
    address: '',
    note: ''
  });
  const navigate = useNavigate();

  const [cartItems, setCartItems] = useState(() => {
    const savedCart = localStorage.getItem('cartItems');
    return savedCart ? JSON.parse(savedCart) : [];
  });

  const [totalAmount, setTotalAmount] = useState(() => {
    return cartItems.reduce((total, item) => {
      return total + item.price * item.quantity;
    }, 0);
  });

  const [userInfo, setUserInfo] = useState(null);

  useEffect(() => {
    const userStr = localStorage.getItem('user_site');
    if (!userStr) {
      navigate('/login');
      return;
    }

    const user = JSON.parse(userStr);
    setUserInfo(user);
    setOrderDetails(prev => ({
      ...prev,
      phone: user.phone || '',
      address: user.address || ''
    }));
  }, [navigate]);

  const handleOrder = async (e) => {
    e.preventDefault();
    
    if (!orderDetails.phone || !orderDetails.address) {
      Swal.fire({
        icon: 'error',
        title: 'Lỗi',
        text: 'Vui lòng điền số điện thoại và địa chỉ!',
        confirmButtonColor: '#16a34a'
      });
      return;
    }

    if (isProcessing) return;

    try {
      setIsProcessing(true);

      const orderData = {
        user_id: userInfo.id,
        name: userInfo.fullname,
        email: userInfo.email,
        phone: orderDetails.phone,
        address: orderDetails.address,
        note: orderDetails.note || 'Thanh toán khi nhận hàng (COD)',
        cart_items: cartItems.map(item => ({
          product_id: item.id,
          qty: item.quantity,
          price: item.price,
          discount: 0
        }))
      };

      const response = await axios.post(
        'http://127.0.0.1:8000/api/order/store',
        orderData
      );

      if (response.data && response.data.status) {
        localStorage.removeItem('cartItems');
        
        Swal.fire({
          icon: 'success',
          title: 'Thành công!',
          text: 'Đặt hàng thành công!',
          showConfirmButton: false,
          timer: 1500,
          background: '#f0fdf4',
          iconColor: '#16a34a'
        }).then(() => {
          navigate('/orders');
        });
      } else {
        throw new Error(response.data.message || 'Lỗi khi đặt hàng');
      }
    } catch (error) {
      console.error('Order error:', error);
      Swal.fire({
        icon: 'error',
        title: 'Lỗi',
        text: error.message || 'Lỗi khi đặt hàng',
        confirmButtonColor: '#16a34a'
      });
    } finally {
      setIsProcessing(false);
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setOrderDetails(prev => ({
      ...prev,
      [name]: value
    }));
  };

  if (!userInfo) return null;

  return (
    <div className="checkout-container">
      <div className="checkout-content">
        <div className="checkout-summary">
          <h2>Thông tin đơn hàng</h2>
          <div className="order-items">
            {cartItems.map((item, index) => (
              <div key={index} className="order-item">
                <div className="item-image">
                  <img 
                    src={`http://127.0.0.1:8000/images/product/${item.thumbnail}`}
                    alt={item.name}
                  />
                </div>
                <div className="item-details">
                  <h3>{item.name}</h3>
                  <div className="item-meta">
                    <span className="quantity">Số lượng: {item.quantity}</span>
                    <span className="price">
                      {new Intl.NumberFormat('vi-VN', { 
                        style: 'currency', 
                        currency: 'VND' 
                      }).format(item.price)}
                    </span>
                  </div>
                  <div className="item-total">
                    {new Intl.NumberFormat('vi-VN', { 
                      style: 'currency', 
                      currency: 'VND' 
                    }).format(item.price * item.quantity)}
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        <div className="checkout-form">
          <div className="form-section">
            <h2>Thông tin giao hàng</h2>
            <form onSubmit={handleOrder}>
              <div className="form-group">
                <label htmlFor="phone">Số điện thoại:</label>
                <input
                  id="phone"
                  type="text"
                  name="phone"
                  value={orderDetails.phone}
                  onChange={handleChange}
                  required
                  placeholder="Nhập số điện thoại của bạn"
                />
              </div>

              <div className="form-group">
                <label htmlFor="address">Địa chỉ giao hàng:</label>
                <input
                  id="address"
                  type="text"
                  name="address"
                  value={orderDetails.address}
                  onChange={handleChange}
                  required
                  placeholder="Nhập địa chỉ giao hàng"
                />
              </div>

              <div className="form-group">
                <label htmlFor="note">Ghi chú:</label>
                <textarea
                  id="note"
                  name="note"
                  value={orderDetails.note}
                  onChange={handleChange}
                  placeholder="Thêm ghi chú cho đơn hàng (nếu có)"
                />
              </div>

              <div className="order-summary">
                <div className="summary-row">
                  <span>Tạm tính:</span>
                  <span>{new Intl.NumberFormat('vi-VN', { 
                    style: 'currency', 
                    currency: 'VND' 
                  }).format(totalAmount)}</span>
                </div>
                <div className="summary-row">
                  <span>Phí vận chuyển:</span>
                  <span>Miễn phí</span>
                </div>
                <div className="summary-row total">
                  <span>Tổng cộng:</span>
                  <span>{new Intl.NumberFormat('vi-VN', { 
                    style: 'currency', 
                    currency: 'VND' 
                  }).format(totalAmount)}</span>
                </div>
              </div>

              <button
                type="submit"
                className="place-order-btn"
                disabled={isProcessing}
              >
                {isProcessing ? 'Đang xử lý...' : 'Đặt hàng'}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Checkout; 