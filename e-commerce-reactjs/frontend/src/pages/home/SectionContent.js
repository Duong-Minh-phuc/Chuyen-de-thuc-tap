"use client"

import { useState } from "react"
import { useNavigate, Link } from "react-router-dom"
import { FaUser, FaLock } from "react-icons/fa"
import { useUser } from "../../context/UserContext"
import axios from "axios"
import "./Login.css"

const SectionContent = () => {
  const [username, setUsername] = useState("")
  const [password, setPassword] = useState("")
  const [error, setError] = useState("")
  const [isLoading, setIsLoading] = useState(false)
  const navigate = useNavigate()
  const { updateUserName } = useUser()

  const handleSubmit = async (e) => {
    e.preventDefault()
    setError("")
    setIsLoading(true)

    try {
      const response = await axios.post("http://127.0.0.1:8000/api/user/login", {
        username: username,
        password: password,
      })

      if (response.data.status) {
        // Lưu thông tin user vào localStorage
        localStorage.setItem("user_site", JSON.stringify(response.data.data))
        // Cập nhật tên người dùng trong context
        updateUserName(response.data.data.name)
        // Chuyển hướng về trang chủ
        navigate("/")
      } else {
        setError(response.data.message)
      }
    } catch (error) {
      console.error("Login error:", error)
      setError("Đăng nhập thất bại: " + (error.response?.data?.message || "Có lỗi xảy ra"))
    } finally {
      setIsLoading(false)
    }
  }

  return (
    <div className="login-container">
      <div className="login-box">
        <div className="login-header">
          <div className="logo-section">
            <div className="logo-icon">
              <span>G</span>
            </div>
            <span className="logo-text">GreenSprout</span>
          </div>
          <h2>Đăng nhập</h2>
          <p className="login-subtitle">Chào mừng bạn trở lại!</p>
        </div>

        <form onSubmit={handleSubmit}>
          <div className="input-group">
            <FaUser className="input-icon" />
            <input
              type="text"
              placeholder="Tên đăng nhập hoặc Email"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              required
              disabled={isLoading}
            />
          </div>
          <div className="input-group">
            <FaLock className="input-icon" />
            <input
              type="password"
              placeholder="Mật khẩu"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
              disabled={isLoading}
            />
          </div>
          {error && <div className="error-message">{error}</div>}
          <button type="submit" className="login-button" disabled={isLoading}>
            {isLoading ? (
              <span className="loading-text">
                <span className="spinner"></span>
                Đang xử lý...
              </span>
            ) : (
              "Đăng nhập"
            )}
          </button>
          <div className="additional-links">
            <Link to="/register" className="register-link">
              Chưa có tài khoản? <strong>Đăng ký ngay</strong>
            </Link>
          </div>
        </form>
      </div>
    </div>
  )
}

export default SectionContent
