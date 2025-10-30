import React from 'react';
import './About.css';
import { FaLeaf, FaHandHoldingHeart, FaSeedling, FaShippingFast } from 'react-icons/fa';
import bedPrepImage from '../assets/images/20230503-bed-prep-sale-bn.jpg';

const About = () => {
    return (
        <div className="about-container">
            {/* Hero Section */}
            <div className="about-hero" style={{ backgroundImage: `linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(${bedPrepImage})` }}>
                <div className="hero-content">
                    <h1>GreenSprout - Nơi Ươm Mầm Xanh</h1>
                    <p>Khám phá thế giới hạt giống chất lượng cao và đa dạng cùng GreenSprout</p>
                </div>
            </div>

            {/* Story Section */}
            <section className="about-section story-section">
                <div className="section-content">
                    <h2>Câu Chuyện Của Chúng Tôi</h2>
                    <p>
                        GreenSprout được thành lập từ tình yêu với nông nghiệp và niềm đam mê với những mầm xanh. 
                        Chúng tôi tin rằng mỗi hạt giống là một tiềm năng sống, và sứ mệnh của chúng tôi 
                        là mang đến cho người trồng trọt những hạt giống chất lượng nhất. Từ những vườn rau 
                        xanh mát đến những khu vườn hoa rực rỡ, từ những luống cà chua sai trĩu đến những 
                        giàn dưa thơm ngát - tất cả đều bắt đầu từ những hạt giống nhỏ bé của chúng tôi.
                    </p>
                </div>
            </section>

            {/* Values Section */}
            <section className="about-section values-section">
                <h2>Giá Trị Cốt Lõi</h2>
                <div className="values-grid">
                    <div className="value-card">
                        <div className="value-icon">
                            <FaLeaf />
                        </div>
                        <h3>Chất Lượng</h3>
                        <p>Cam kết 100% hạt giống sạch, nguồn gốc rõ ràng và tỷ lệ nảy mầm cao</p>
                    </div>
                    <div className="value-card">
                        <div className="value-icon">
                            <FaHandHoldingHeart />
                        </div>
                        <h3>Tận Tâm</h3>
                        <p>Tư vấn chuyên nghiệp, chia sẻ kinh nghiệm trồng trọt chi tiết</p>
                    </div>
                    <div className="value-card">
                        <div className="value-icon">
                            <FaSeedling />
                        </div>
                        <h3>Đa Dạng</h3>
                        <p>Đa dạng chủng loại từ rau củ, hoa các loại đến cây ăn quả</p>
                    </div>
                    <div className="value-card">
                        <div className="value-icon">
                            <FaShippingFast />
                        </div>
                        <h3>Tiện Lợi</h3>
                        <p>Giao hàng nhanh chóng, đóng gói kỹ càng, bảo quản chuyên nghiệp</p>
                    </div>
                </div>
            </section>

            {/* Commitment Section */}
            <section className="about-section commitment-section">
                <div className="section-content">
                    <h2>Cam Kết Với Khách Hàng</h2>
                    <div className="commitment-list">
                        <div className="commitment-item">
                            <h3>Hạt Giống Chất Lượng</h3>
                            <p>Tất cả hạt giống được tuyển chọn kỹ càng từ những nhà cung cấp uy tín, 
                            đảm bảo độ thuần chủng và sức sống mạnh mẽ</p>
                        </div>
                        <div className="commitment-item">
                            <h3>Hỗ Trợ Kỹ Thuật</h3>
                            <p>Đội ngũ chuyên gia nông nghiệp giàu kinh nghiệm luôn sẵn sàng tư vấn 
                            về kỹ thuật trồng trọt và chăm sóc cây</p>
                        </div>
                        <div className="commitment-item">
                            <h3>Chính Sách Bảo Đảm</h3>
                            <p>Cam kết tỷ lệ nảy mầm trên 85%, chính sách đổi trả miễn phí 
                            nếu hạt giống không đạt chất lượng</p>
                        </div>
                    </div>
                </div>
            </section>

            {/* Contact Section */}
            <section className="about-section contact-section">
                <div className="section-content">
                    <h2>Liên Hệ Với Chúng Tôi</h2>
                    <div className="contact-info">
                        <div className="contact-item">
                            <h3>Địa Chỉ</h3>
                            <p>123 Đường Nông Nghiệp, Quận Thủ Đức, TP.HCM</p>
                        </div>
                        <div className="contact-item">
                            <h3>Điện Thoại</h3>
                            <p>(028) 1234-5678</p>
                        </div>
                        <div className="contact-item">
                            <h3>Email</h3>
                            <p>contact@greensprout.com</p>
                        </div>
                        <div className="contact-item">
                            <h3>Giờ Làm Việc</h3>
                            <p>Thứ 2 - Chủ Nhật: 08:00 - 20:00</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
};

export default About;