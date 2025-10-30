// Tạo Footer
const footer = document.createElement('footer');
footer.style = `
    background-color: black;
    color: white;
    padding: 20px 40px;
    margin-top:400px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
`;

// Phần thông tin doanh nghiệp
const businessInfo = document.createElement('div');
businessInfo.innerHTML = `
    <h3>HỘ KINH DOANH BLANC PERFUME</h3>
    <p>GPKD số: 58A8011955</p>
    <p>Ngày cấp: 01/10/2021</p>
    <p>Cấp bởi: UBND TP Trà Vinh</p>
    <p>77 Điện Biên Phủ, P.6, Trà Vinh</p>
    <p>📞 0966434787</p>
    <p>✉️ Support@blanc.com</p>
    <p>✉️ Outreach@blanc.com.vn</p>
`;
businessInfo.style = `
    flex: 1;
`;

// Phần hỗ trợ khách hàng
const customerSupport = document.createElement('div');
customerSupport.innerHTML = `
    <h3>HỖ TRỢ KHÁCH HÀNG</h3>
    <ul>
        <li>Chính sách bảo mật</li>
        <li>Chính sách vận chuyển</li>
        <li>Chính sách đổi trả</li>
        <li>Hình thức thanh toán</li>
    </ul>
`;
customerSupport.style = `
    flex: 1;
`;
customerSupport.querySelectorAll('li').forEach((li) => {
    li.style = `
        list-style: none;
        margin-bottom: 5px;
    `;
});

// Phần hướng dẫn
const guidance = document.createElement('div');
guidance.innerHTML = `
    <h3>HƯỚNG DẪN</h3>
    <ul>
        <li>Hướng dẫn mua hàng</li>
        <li>Hướng dẫn thanh toán</li>
        <li>Hướng dẫn giao nhận</li>
        <li>Điều khoản dịch vụ</li>
    </ul>
`;
guidance.style = `
    flex: 1;
`;
guidance.querySelectorAll('li').forEach((li) => {
    li.style = `
        list-style: none;
        margin-bottom: 5px;
    `;
});

// Phần logo Bộ Công Thương


// Gắn các phần vào footer
footer.append(businessInfo, customerSupport, guidance);

// Thêm footer vào trang
document.body.appendChild(footer);
