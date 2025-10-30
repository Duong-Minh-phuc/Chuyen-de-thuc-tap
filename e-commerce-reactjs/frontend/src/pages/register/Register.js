import React, { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import { FaUser, FaLock, FaEnvelope, FaPhone, FaMapMarkerAlt } from 'react-icons/fa';
import axios from 'axios';
import './Register.css';

const Register = () => {
    const [formData, setFormData] = useState({
        fullname: "",
        email: "",
        phone: "",
        username: "",
        password: "",
        confirmPassword: "",
        address: "",
        thumbnail: null,
        roles: "customer",
        status: 1
    });
    const [error, setError] = useState("");
    const [imagePreview, setImagePreview] = useState(null);
    const navigate = useNavigate();

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setFormData(prev => ({
                ...prev,
                thumbnail: file
            }));
            // Tạo preview cho hình ảnh
            const reader = new FileReader();
            reader.onloadend = () => {
                setImagePreview(reader.result);
            };
            reader.readAsDataURL(file);
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError('');

        // Kiểm tra mật khẩu xác nhận
        if (formData.password !== formData.confirmPassword) {
            setError('Mật khẩu xác nhận không khớp');
            return;
        }

        // Kiểm tra file hình
        if (!formData.thumbnail) {
            setError('Vui lòng chọn hình đại diện');
            return;
        }

        try {
            const formDataToSend = new FormData();
            formDataToSend.append('thumbnail', formData.thumbnail);
            formDataToSend.append('fullname', formData.fullname);
            formDataToSend.append('email', formData.email);
            formDataToSend.append('phone', formData.phone);
            formDataToSend.append('username', formData.username);
            formDataToSend.append('password', formData.password);
            formDataToSend.append('address', formData.address);
            formDataToSend.append('roles', formData.roles);
            formDataToSend.append('status', formData.status);

            const response = await axios.post(
                'http://127.0.0.1:8000/api/user/register',
                formDataToSend,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            );
            
            if (response.data.status) {
                alert('Đăng ký thành công!');
                navigate('/login');
            } else {
                setError(response.data.message || 'Đăng ký thất bại');
            }
        } catch (error) {
            setError('Đăng ký thất bại: ' + (error.response?.data?.message || error.message));
        }
    };

    return (
        <div className="register-container">
            <div className="register-box">
                <h2>Đăng ký tài khoản</h2>
                <form onSubmit={handleSubmit}>
                    <div className="image-upload-container">
                        <input
                            type="file"
                            accept="image/*"
                            onChange={handleImageChange}
                            className="image-input"
                            id="image-upload"
                        />
                        <label htmlFor="image-upload" className="image-upload-label">
                            {imagePreview ? (
                                <img src={imagePreview} alt="Preview" className="image-preview" />
                            ) : (
                                <div className="upload-placeholder">
                                    <FaUser className="upload-icon" />
                                    <span>Chọn hình đại diện</span>
                                </div>
                            )}
                        </label>
                    </div>

                    <div className="input-group">
                        <FaUser className="input-icon" />
                        <input
                            type="text"
                            name="name"
                            placeholder="Họ và tên"
                            value={formData.name}
                            onChange={handleInputChange}
                            required
                        />
                    </div>

                    <div className="input-group">
                        <FaUser className="input-icon" />
                        <input
                            type="text"
                            name="username"
                            placeholder="Tên đăng nhập"
                            value={formData.username}
                            onChange={handleInputChange}
                            required
                        />
                    </div>

                    <div className="input-group">
                        <FaEnvelope className="input-icon" />
                        <input
                            type="email"
                            name="email"
                            placeholder="Email"
                            value={formData.email}
                            onChange={handleInputChange}
                            required
                        />
                    </div>

                    <div className="input-group">
                        <FaPhone className="input-icon" />
                        <input
                            type="tel"
                            name="phone"
                            placeholder="Số điện thoại"
                            value={formData.phone}
                            onChange={handleInputChange}
                            required
                        />
                    </div>

                    <div className="input-group">
                        <FaMapMarkerAlt className="input-icon" />
                        <input
                            type="text"
                            name="address"
                            placeholder="Địa chỉ"
                            value={formData.address}
                            onChange={handleInputChange}
                            required
                        />
                    </div>

                    <div className="input-group">
                        <FaLock className="input-icon" />
                        <input
                            type="password"
                            name="password"
                            placeholder="Mật khẩu"
                            value={formData.password}
                            onChange={handleInputChange}
                            required
                        />
                    </div>

                    <div className="input-group">
                        <FaLock className="input-icon" />
                        <input
                            type="password"
                            name="confirmPassword"
                            placeholder="Xác nhận mật khẩu"
                            value={formData.confirmPassword}
                            onChange={handleInputChange}
                            required
                        />
                    </div>

                    {error && <div className="error-message">{error}</div>}
                    
                    <button type="submit" className="register-button">
                        Đăng ký
                    </button>

                    <div className="additional-links">
                        <Link to="/login" className="login-link">
                            Đã có tài khoản? Đăng nhập
                        </Link>
                    </div>
                </form>
            </div>

            <style jsx>{`
                .image-upload-container {
                    margin-bottom: 20px;
                    text-align: center;
                }

                .image-input {
                    display: none;
                }

                .image-upload-label {
                    cursor: pointer;
                    display: block;
                    width: 120px;
                    height: 120px;
                    margin: 0 auto;
                    border-radius: 60px;
                    border: 2px dashed #ccc;
                    overflow: hidden;
                }

                .upload-placeholder {
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    background: #f8f9fa;
                }

                .upload-icon {
                    font-size: 24px;
                    margin-bottom: 8px;
                    color: #666;
                }

                .image-preview {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .upload-placeholder span {
                    font-size: 12px;
                    color: #666;
                }
            `}</style>
        </div>
    );
};

export default Register; 