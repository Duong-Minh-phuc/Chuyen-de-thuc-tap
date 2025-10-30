import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './Header.css';
import { Link, useNavigate } from 'react-router-dom';
import { useCart } from '../context/CartContext';
import { useUser } from '../context/UserContext';
import { FaShoppingCart, FaBars } from 'react-icons/fa';

function Header() {
  const [menus, setMenus] = useState([]);
  const { totalItems } = useCart();
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const navigate = useNavigate();
  const { userName, updateUserName } = useUser();
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [userInfo, setUserInfo] = useState(null);
  const [isUserDropdownOpen, setIsUserDropdownOpen] = useState(false);

  useEffect(() => {
    const userStr = localStorage.getItem("user_site");
    if (userStr) {
      const userData = JSON.parse(userStr);
      setUserInfo(userData);
      setIsLoggedIn(true);
      updateUserName(userData.fullname);
    }

    axios.get("http://127.0.0.1:8000/api/menu")
      .then((response) => {
        if (response.data && Array.isArray(response.data.data.data)) {
          const parentMenus = response.data.data.data.filter((menu) => menu.parent_id === 0);
          parentMenus.forEach((parent) => {
            parent.children = response.data.data.data.filter((menu) => menu.parent_id === parent.id);
          });
          setMenus(parentMenus);
        } else {
          console.error("Invalid menu data:", response.data);
          setMenus([]);
        }
      })
      .catch((error) => {
        console.error("Error fetching menu data!", error);
        setMenus([]);
      });
  }, [updateUserName]);

  const handleLogout = () => {
    localStorage.removeItem("user_site");
    localStorage.removeItem("cartItems");
    setIsLoggedIn(false);
    setUserInfo(null);
    updateUserName("");
    setIsUserDropdownOpen(false);
    navigate("/login");
  };

  // Close dropdown when clicking outside
  useEffect(() => {
    const handleClickOutside = (event) => {
      if (isUserDropdownOpen && !event.target.closest('.user-menu-wrapper')) {
        setIsUserDropdownOpen(false);
      }
    };

    document.addEventListener('mousedown', handleClickOutside);
    return () => document.removeEventListener('mousedown', handleClickOutside);
  }, [isUserDropdownOpen]);

  return (
    <header className="header">
      <Link to="/" className="logo">
        <div className="logo-icon">
          <span>G</span>
        </div>
        <span className="logo-text">GreenSprout</span>
      </Link>

      <nav className={`nav-menu ${isMobileMenuOpen ? 'active' : ''}`}>
        {menus.map((menu) => (
          <Link key={menu.id} to={menu.link || "#"} className="nav-item">
            {menu.name}
            {menu.children && menu.children.length > 0 && (
              <div className="dropdown-menu">
                {menu.children.map((child) => (
                  <Link key={child.id} to={child.link || "#"} className="dropdown-item">
                    {child.name}
                  </Link>
                ))}
              </div>
            )}
          </Link>
        ))}
      </nav>

      <div className="actions">
        {isLoggedIn ? (
          <div className="user-menu-wrapper">
            <button
              className="user-button"
              onClick={() => setIsUserDropdownOpen(!isUserDropdownOpen)}
            >
              <span className="user-name">{userInfo.fullname}</span>
            </button>

            {isUserDropdownOpen && (
              <div className="user-dropdown">
                <Link to="/profile" className="dropdown-item">Tài khoản của tôi</Link>
                <Link to="/orders" className="dropdown-item">Đơn hàng</Link>
                <div className="dropdown-divider"></div>
                <button onClick={handleLogout} className="dropdown-item logout-button">
                  Đăng xuất
                </button>
              </div>
            )}
          </div>
        ) : (
          <Link to="/login" className="sign-in-button">
            <span>Đăng nhập</span>
          </Link>
        )}

        <Link to="/cart" className="cart-button">
          <FaShoppingCart />
          {totalItems > 0 && <span className="cart-count">{totalItems}</span>}
        </Link>

        <button 
          className="mobile-toggle" 
          onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
          aria-label="Toggle mobile menu"
        >
          <FaBars />
        </button>
      </div>
    </header>
  );
}

export default Header;


