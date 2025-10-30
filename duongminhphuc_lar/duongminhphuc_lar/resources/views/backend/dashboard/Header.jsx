import React from 'react';
import { Navbar, Nav, Dropdown, Container } from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';


const Header = () => {
  return (
    <Navbar bg="dark" variant="dark" expand="lg">
      <Container>
        <Navbar.Brand href="/admin">Quản lý hệ thống</Navbar.Brand>
        <Navbar.Toggle aria-controls="basic-navbar-nav" />
        <Navbar.Collapse id="basic-navbar-nav">
          <Nav className="me-auto">
            <Dropdown>
              <Dropdown.Toggle variant="dark" id="product-dropdown">
                Sản phẩm
              </Dropdown.Toggle>
              <Dropdown.Menu>
                <Dropdown.Item href="/admin/product">Danh sách sản phẩm</Dropdown.Item>
                <Dropdown.Item href="/admin/category">Danh mục</Dropdown.Item>
                <Dropdown.Item href="/admin/brand">Thương hiệu</Dropdown.Item>
              </Dropdown.Menu>
            </Dropdown>
            <Dropdown>
              <Dropdown.Toggle variant="dark" id="post-dropdown">
                Bài viết
              </Dropdown.Toggle>
              <Dropdown.Menu>
                <Dropdown.Item href="/admin/post">Danh sách bài viết</Dropdown.Item>
                <Dropdown.Item href="/admin/topic">Chủ đề</Dropdown.Item>
              </Dropdown.Menu>
            </Dropdown>
            <Dropdown>
              <Dropdown.Toggle variant="dark" id="interface-dropdown">
                Giao diện
              </Dropdown.Toggle>
              <Dropdown.Menu>
                <Dropdown.Item href="/admin/menu">Menu</Dropdown.Item>
                <Dropdown.Item href="/admin/banner">Banner</Dropdown.Item>
              </Dropdown.Menu>
            </Dropdown>
            <Nav.Link href="/admin/contact">Liên hệ</Nav.Link>
            <Nav.Link href="/admin/order">Đơn hàng</Nav.Link>
            <Nav.Link href="/admin/user">Thành viên</Nav.Link>
          </Nav>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}

export default Header;
