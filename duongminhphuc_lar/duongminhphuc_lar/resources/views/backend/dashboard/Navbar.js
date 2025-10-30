import React, { useContext, useState } from 'react';
import { Navbar, Nav } from 'react-bootstrap';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faBars, faUserCog, faPowerOff } from '@fortawesome/free-solid-svg-icons';
import 'bootstrap/dist/css/bootstrap.min.css';
import './Footer.css';
import { AuthContext } from '../../pages/frontend/AuthorContext';
import { Link } from 'react-router-dom';
import { UrlImg } from '../../config';
const CustomNavbar = ({ toggleSidebar }) => {
    const { authState, logout } = useContext(AuthContext);
    const [dropdownOpen, setDropdownOpen] = useState(false);

    const toggleDropdown = () => setDropdownOpen(!dropdownOpen);

    return (
        <Navbar bg="light" expand="lg">
            <Navbar.Brand href="/admin">
              
            <h3 className="nav-item text-main" style={{marginLeft:"30px"}}>
            <a className="nav-link active" href="/admin">
            <i class="fa-solid fa-screwdriver-wrench"></i>
           Quản Lý Admin
            </a>
          </h3>
            </Navbar.Brand>
            <Navbar.Toggle aria-controls="basic-navbar-nav" />
            <Navbar.Collapse id="basic-navbar-nav">
                <Nav style={{ marginLeft: "auto" }}> {/* Align to the right */}
                    <Nav.Link className="nav-link" onClick={toggleSidebar} role="button">
                        <FontAwesomeIcon icon={faBars} />
                    </Nav.Link>
                    <Nav.Link href="/admin">Home</Nav.Link>
                    <Nav.Link href="/admin/contact">Contact</Nav.Link>
                </Nav>
                <Nav className="ml-auto d-flex align-items-center"> {/* Use ml-auto to push it to the right */}
                    {authState.isAuthenticated ? (
                        <div className="user-info" style={{ position: 'relative' }}>
                            <span
                                style={{ marginTop: "10px", cursor: 'pointer' }}
                                onClick={toggleDropdown}
                            >
          
                                {authState.username}
                               
                            </span>
                            {dropdownOpen && (
                                <div className="dropdown-menu text-white" style={{ position: 'absolute', top: '100%', right: 0, backgroundColor: '#007bff', borderRadius: '5px', zIndex: 1 }}>
                                    <button onClick={logout} className="logout-button" style={{ background: 'none', border: 'none', color: '#fff', padding: '10px', cursor: 'pointer' }}>Đăng Xuất</button>
                                </div>
                            )}
                        </div>
                    ) : (
                        <Link to={`/admin/loginadmin`}>
                            <h6 style={{ marginTop: "10px" }} >Đăng Nhập</h6>
                        </Link>
                    )}
                </Nav>
            </Navbar.Collapse>
        </Navbar>
    );
};

export default CustomNavbar;
