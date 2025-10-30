import React, { useState } from 'react';
import Navbar from './Navbar';
import Sidebar from './Sidebar';
import Footer from './Footer';
import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import { Outlet } from 'react-router-dom';


const LayoutAdmin = () => {
  const [sidebarOpen, setSidebarOpen] = useState(true);

  const toggleSidebar = () => {
    setSidebarOpen(!sidebarOpen);
  };

  return (
    <div className="container-fluid">
      <div className="row">
        <Navbar toggleSidebar={toggleSidebar} />
      </div>
      <div className="row">
        {sidebarOpen && <Sidebar />}
        <div className={sidebarOpen ? 'col-md-9 content' : 'col-md-12 content'}>
          <div className="card">
            <div className="card-body">
              <Outlet>
                {/* <Content /> */}
              </Outlet>
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  );
};

export default LayoutAdmin;
