import React, { useEffect } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import axios from 'axios';
import { toast } from 'react-hot-toast';

const MomoCallback = () => {
    const navigate = useNavigate();
    const location = useLocation();

    useEffect(() => {
        const handleMomoCallback = async () => {
            try {
                // Lấy thông tin từ URL MoMo trả về
                const urlParams = new URLSearchParams(location.search);
                const resultCode = urlParams.get('resultCode');
                const message = urlParams.get('message');
                const orderId = urlParams.get('orderId');
                const amount = urlParams.get('amount');

                console.log('MOMO Callback Data:', {
                    resultCode,
                    message,
                    orderId,
                    amount
                });

                // Lấy thông tin đơn hàng đã lưu
                const pendingOrder = JSON.parse(localStorage.getItem('pending_order'));
                const user = JSON.parse(localStorage.getItem('user'));
                const token = localStorage.getItem('authToken');

                if (!pendingOrder || !user || !token) {
                    console.error('Missing order information:', { pendingOrder, user, token });
                    toast.error('Không tìm thấy thông tin đơn hàng!');
                    navigate('/cart');
                    return;
                }

                // Kiểm tra kết quả thanh toán từ MoMo
                if (resultCode === '0') {
                    try {
                        // Tạo đơn hàng với API
                        const orderResponse = await axios.post(
                            `http://localhost:8080/api/public/users/${user.email}/carts/${user.GH.cartId}/payments/2/phone/${pendingOrder.userInfo.phone}/address/${encodeURIComponent(pendingOrder.userInfo.address)}/order`,
                            {},
                            {
                                headers: {
                                    'Authorization': `Bearer ${token}`,
                                    'Content-Type': 'application/json'
                                }
                            }
                        );

                        console.log('Order Response:', orderResponse);

                        if (orderResponse.status === 201) {
                            const newOrderId = orderResponse.data.orderId || orderResponse.data.order.id;

                            // Gửi email xác nhận
                            try {
                                await axios.post('http://localhost:4500/send-email', {
                                    userEmail: user.email,
                                    orderDetails: pendingOrder.items,
                                    totalAmount: pendingOrder.totalAmount,
                                    orderId: newOrderId
                                });
                                console.log('Email sent successfully');
                                toast.success('Đơn hàng đã được xác nhận và email xác nhận đã được gửi!');
                            } catch (emailError) {
                                console.error('Email sending error:', emailError);
                                toast.error('Đặt hàng thành công nhưng không thể gửi email xác nhận!');
                            }

                            // Xóa dữ liệu tạm
                            localStorage.removeItem('pending_order');
                            localStorage.removeItem('checkoutItems');

                            toast.success('Thanh toán thành công!');
                            navigate('/orders');
                        }
                    } catch (error) {
                        console.error('Order creation error:', error.response || error);
                        toast.error('Lỗi khi tạo đơn hàng. Vui lòng liên hệ hỗ trợ!');
                        navigate('/cart');
                    }
                } else {
                    console.error('Payment failed:', message);
                    toast.error(`Thanh toán thất bại: ${message}`);
                    localStorage.removeItem('pending_order');
                    navigate('/cart');
                }
            } catch (error) {
                console.error('Callback processing error:', error);
                toast.error('Có lỗi xảy ra khi xử lý thanh toán!');
                localStorage.removeItem('pending_order');
                navigate('/cart');
            }
        };

        handleMomoCallback();
    }, [navigate, location]);

    return (
        <div className="loading-container" style={{
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center',
            height: '100vh',
            flexDirection: 'column',
            gap: '20px'
        }}>
            <div className="spinner" style={{
                width: '50px',
                height: '50px',
                border: '5px solid #f3f3f3',
                borderTop: '5px solid #ae2070',
                borderRadius: '50%',
                animation: 'spin 1s linear infinite'
            }}></div>
            <div className="loading" style={{
                fontSize: '18px',
                color: '#333'
            }}>Đang xử lý thanh toán...</div>
            <style>
                {`
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                `}
            </style>
        </div>
    );
};

export default MomoCallback; 