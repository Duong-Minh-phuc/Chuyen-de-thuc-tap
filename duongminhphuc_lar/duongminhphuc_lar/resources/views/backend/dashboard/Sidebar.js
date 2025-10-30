import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import { Link } from 'react-router-dom';

const Sidebar = () => {
  return (
    <nav id="sidebarMenu" className="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div className="sidebar-sticky pt-3">
        <ul className="nav flex-column">
          <li className="nav-item">
            <a className="nav-link active" href="#">
            <i class="fa-brands fa-product-hunt"></i>
              Sản phẩm
            </a>
          </li>
          <li className="nav-item" >
            <Link  to={`/admin/product`} className='nav-link' >Tất cả sản phẩm</Link>
          </li>
          <li className="nav-item">
          <Link  to={`/admin/category`} className='nav-link' >Danh mục</Link>
          </li>
          <li className="nav-item">
          <Link  to={`/admin/brand`} className='nav-link' >Thương hiệu</Link>
          </li>
          <li className="nav-item">
            <a className="nav-link active" href="#">
            <i class="fa-solid fa-book"></i>
             Bài viết
            </a>
          </li>
          <li className="nav-item">
          <Link  to={`/admin/post`} className='nav-link' >Tất cả bài viết</Link>
          </li>
          <li className="nav-item">
          <Link  to={`/admin/topic`} className='nav-link' >Chủ đề</Link>
          </li>
          <li className="nav-item">
            <a className="nav-link active" href="#">
            <i class="fa-sharp fa-solid fa-tv"></i>
           Giao diện
            </a>
          </li>
          <li className="nav-item">
          <Link  to={`/admin/menu`} className='nav-link' >Menu</Link>
          </li>
          <li className="nav-item">
          <Link  to={`/admin/banner`} className='nav-link' >Banner</Link>
          </li>
          <li className="nav-item">
            <Link to={`/admin/order`} className="nav-link active" >
            <i class="fa-sharp fa-solid fa-truck-fast"></i>
          Đơn hàng
            </Link>
          </li>
          <li className="nav-item">
          <Link to={`/admin/contact`} className="nav-link active" >
            <i class="fa-sharp fa-solid fa-address-card"></i>
          Liên hệ
            </Link>
          </li>
          <li className="nav-item">
          <Link to={`/admin/user`} className="nav-link active" >
          <i class="fa-solid fa-user"></i>
          User
            </Link>
          </li>
        </ul>
      </div>
    </nav>
  );
};

export default Sidebar;
