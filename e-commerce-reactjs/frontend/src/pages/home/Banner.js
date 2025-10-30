import React from 'react';
import './Banner.css';
import { Link } from 'react-router-dom';
import fullLogo from '../../assets/images/fulllogo.png';

const Banner = () => {
    return (
        <main className="flex-1">
            <section className="banner-section">
                <div className="banner-container">
                    <div className="banner-content">
                        <div className="banner-text">
                            <h1 className="banner-title">
                                Hạt Giống F1 Chất Lượng Cao
                            </h1>
                            <p className="banner-description">
                                Khám phá bộ sưu tập hạt giống F1 chất lượng cao của chúng tôi, bao gồm rau củ, hoa và thảo mộc. 
                                Bắt đầu hành trình làm vườn của bạn ngay hôm nay!
                            </p>
                            <div className="banner-buttons">
                                <Link to="/products" className="shop-now-btn">
                                    Mua Ngay
                                </Link>
                                <Link to="/about" className="learn-more-btn">
                                    Tìm Hiểu Thêm
                                </Link>
                            </div>
                        </div>
                        <div className="banner-image-container">
                            <img
                                src={fullLogo}
                                alt="Phúc Nông - F1 Plant Seeds"
                                className="banner-image"
                            />
                        </div>
                    </div>
                </div>
            </section>
        </main>
    );
};

export default Banner;
