import "./assets/sass/app.scss"; 
import React from 'react';
import Header from './layouts/Header' 
import Footer from './layouts/Footer' 
import Main from './layouts/Main' 
import 'bootstrap/dist/css/bootstrap.min.css';
import AllProducts from './pages/AllProducts';

import { Route, Routes } from 'react-router-dom';
import { UserProvider } from './context/UserContext';
import { CartProvider } from './context/CartContext';

import GrowingInstruct from './pages/GrowingInstruct';
import AllPosts from './pages/AllPosts';
import CreatePost from './pages/CreatePost';
import AdminApp from './admin/AdminApp';
import SectionContent from "./pages/home/SectionContent";
import Register from "./pages/register/Register";
import ProductDetail from "./pages/ProductDetail";
import Cart from "./pages/Cart";
import Order from "./pages/Orders";
import Checkout from "./pages/Checkout";
import OrderDetail from "./pages/OrderDetail";
import Profile from "./pages/Profile";
import MomoCallback from './pages/MomoCallback';
import SearchResults from './pages/SearchResults';
import ProductCategory from './pages/ProductCategory';
import ProductBrand from './pages/ProductBrand';
import PostDetail from './pages/PostDetail';
import TopicsPost from './pages/TopicsPost';
import Topics from './pages/Topics';
import LatestPosts from './pages/LatestPosts';
import About from './pages/About';

function App() { 
    return (
        <UserProvider>
            <CartProvider>
                <Routes>
                    {/* Admin routes */}
                   
                    
                    {/* Client routes */}
                    <Route path="/*" element={
                        <div> 
                            <Header /> 
                            <Routes>
                                <Route path="/" element={<Main />} />
                                <Route path="/tat-ca-bai-viet" element={<AllPosts />} />
                                <Route path="/bai-viet-moi" element={<LatestPosts />} />
                                <Route path="/chu-de-bai-viet" element={<Topics />} />
                                <Route path="/chu-de-bai-viet/:slug" element={<TopicsPost />} />
                                <Route path="/chi-tiet-bai-viet/:slug" element={<PostDetail />} />
                                <Route path="/gioi-thieu" element={<About />} />
                                <Route path="/posts/create" element={<CreatePost />} />
                                <Route path="/orders" element={<Order />} />
                                <Route path="/tat-ca-hat-giong" element={<AllProducts />} />
                                <Route path="/search" element={<SearchResults />} />
                                <Route path="/login" element={<SectionContent />} />
                                <Route path="/register" element={<Register />} />
                                <Route path="/huong-dan-trong-hat-giong" element={<GrowingInstruct />} />
                                <Route path="/danh-muc/:slug" element={<ProductCategory />} />
                                <Route path="/thuong-hieu/:slug" element={<ProductBrand />} />
                                <Route path="/detail/:slug" element={<ProductDetail />} />
                                <Route path="/cart" element={<Cart />} />
                                <Route path="/profile" element={<Profile />} />
                                <Route path="/checkout" element={<Checkout />} />
                                <Route path="/orders/:orderId" element={<OrderDetail />} />
                                <Route path="/order" element={<MomoCallback />} />
                            </Routes>
                            <Footer /> 
                        </div>
                    } />
                </Routes>
            </CartProvider>
        </UserProvider>
    ); 
} 

export default App;
