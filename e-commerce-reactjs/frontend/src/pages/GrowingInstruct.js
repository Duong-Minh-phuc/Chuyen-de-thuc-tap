import React from 'react';
import './GrowingInstruct.css';
import seedingImage from '../assets/images/avatars/gieotrong.jpg';

const GrowingInstruct = () => {
    return (
        <div className="growing-container">
            <div className="growing-hero">
                <div className="hero-content">
                    <h1>Hướng Dẫn Gieo Trồng</h1>
                    <p>Quy trình gieo hạt chuẩn cho mọi loại cây trồng</p>
                </div>
            </div>

            <div className="instruction-container">
                <section className="preparation-section">
                    <h2>Bước 1: Chuẩn Bị Vật Dụng và Chất Trồng</h2>
                    <div className="materials-grid">
                        <div className="material-card">
                            <h3>Chậu & Khay Ươm</h3>
                            <p>- Chậu nhỏ hoặc khay ươm cho số lượng lớn</p>
                            <p>- Chậu to nếu không muốn thay chậu sau này</p>
                            <p>- Nên ươm trong chậu để dễ kiểm soát độ ẩm và sâu bệnh</p>
                        </div>
                        <div className="material-card">
                            <h3>Thuốc Trừ Nấm</h3>
                            <p>- Phòng ngừa nấm mốc gây hại</p>
                            <p>- Bảo vệ hạt giống trong giai đoạn nảy mầm</p>
                            <p>- Sử dụng theo hướng dẫn nhà sản xuất</p>
                        </div>
                        <div className="material-card">
                            <h3>Đất Trồng</h3>
                            <p>- Hỗn hợp cám dừa + tro trấu (tỷ lệ 7:3)</p>
                            <p>- Có thể dùng 100% cám dừa</p>
                            <p>- Ngâm xả cám dừa để hết tanin</p>
                        </div>
                    </div>
                </section>

                <section className="process-section">
                    <h2>Bước 2: Quy Trình Gieo Hạt</h2>
                    <div className="process-steps">
                        <div className="step-image">
                            <img src={seedingImage} alt="Quy trình gieo hạt" />
                        </div>
                        <div className="step-content">
                            <div className="step">
                                <div className="step-text">
                                    <h3>1. Chuẩn Bị Chất Trồng</h3>
                                    <p>- Trộn đều chất trồng và cho vào chậu</p>
                                    <p>- Tưới đẫm nước</p>
                                    <p>- Phun thuốc trừ nấm 2-3 lần</p>
                                </div>
                            </div>

                            <div className="step">
                                <div className="step-text">
                                    <h3>2. Ngâm Hạt Giống</h3>
                                    <p>- Hạt vỏ mỏng: ngâm nước ấm 5-8 tiếng</p>
                                    <p>- Hạt vỏ dày: ngâm nước ấm (7 lạnh 3 nóng) qua đêm</p>
                                </div>
                            </div>

                            <div className="step">
                                <div className="step-text">
                                    <h3>3. Ủ Hạt Giống</h3>
                                    <p>- Thời gian ủ tùy loại hạt</p>
                                    <p>- Có thể dùng GA3, Atonik cho hạt khó nảy mầm</p>
                                    <p>- Chú ý nồng độ để tránh làm chết hạt</p>
                                </div>
                            </div>

                            <div className="step">
                                <div className="step-text">
                                    <h3>4. Gieo Hạt</h3>
                                    <p>- Độ sâu bằng 2-3 lần đường kính hạt</p>
                                    <p>- Hạt nhỏ: gieo trên mặt đất ẩm</p>
                                    <p>- Hạt to: chôn sâu 1-2cm, không nén chặt</p>
                                </div>
                            </div>

                            <div className="step">
                                <div className="step-text">
                                    <h3>5. Chăm Sóc Sau Gieo</h3>
                                    <p>- Phun sương để đất và hạt tiếp xúc tốt</p>
                                    <p>- Hạt xứ lạnh: đậy màng bọc hoặc kính</p>
                                    <p>- Đặt nơi ít nắng và giữ ẩm</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section className="tips-section">
                    <h2>Lưu Ý Quan Trọng</h2>
                    <div className="tips-grid">
                        <div className="tip-card">
                            <h3>Thời Gian</h3>
                            <p>Lên kế hoạch gieo trồng và chuẩn bị đầy đủ vật dụng trước khi bắt đầu</p>
                        </div>
                        <div className="tip-card">
                            <h3>Độ Ẩm</h3>
                            <p>Duy trì độ ẩm phù hợp, không để quá ướt hoặc quá khô</p>
                        </div>
                        <div className="tip-card">
                            <h3>Chăm Sóc</h3>
                            <p>Theo dõi thường xuyên và điều chỉnh điều kiện kịp thời</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    );
};

export default GrowingInstruct; 