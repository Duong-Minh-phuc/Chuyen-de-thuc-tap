import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import './Footer.css'; // Make sure to create and import your custom CSS file

const Footer = () => {
  return (
    <footer className="footer mt-auto py-3 bg-light">
      <div className="container custom-footer">
        <span className="text-muted">Sửa bởi: Phi Trường. All rights reserved. <b>Version</b> 3.0.0</span>
      </div>
    </footer>
  );
};

export default Footer;
