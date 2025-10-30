import React from 'react'
import Banner from '../pages/home/Banner'
import Deal from '../pages/home/Deal'
import Chat from '../pages/home/Chat'
import Section1 from '../pages/home/Section1'
import './Home.css'
    

// import Request from '../pages/home/Request'  // Comment lại vì chưa tạo
// import Items from '../pages/home/Items'      // Comment lại vì chưa tạo
// import Services from '../pages/home/Services' // Comment lại vì chưa tạo
// import Region from '../pages/home/Region'    // Comment lại vì chưa tạo
// import Subscribe from '../pages/home/Subscribe' // Comment lại vì chưa tạo
import { useUser } from "../context/UserContext"
import { useCart } from "../context/CartContext"
import { useEffect, useState, useRef } from "react"
import { Link, useNavigate } from "react-router-dom"
import Seed from '../pages/home/Seed'
import { FaShoppingCart, FaSearch, FaUser, FaChevronDown, FaBars, FaTimes } from "react-icons/fa"

function Home() {
    const { userName, updateUserName } = useUser()
    const [categories, setCategories] = useState([])
    const [searchTerm, setSearchTerm] = useState("")
    const [menus, setMenus] = useState([])
    const navigate = useNavigate()
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false)
    const [activeDropdown, setActiveDropdown] = useState(null)
    const navbarRef = useRef(null)
    
    const handleSearch = (e) => {
        e.preventDefault()
        if (searchTerm.trim()) {
          navigate(`/search?q=${encodeURIComponent(searchTerm.trim())}`)
          setSearchTerm("")
        }
    }

    return (
        <div className="main-container">
            <div className="content-wrapper">
                <div className="search-container">
                    <div className="search-wrapper">
                        <form onSubmit={handleSearch} className="search-box">
                            <input
                                type="search"
                                placeholder="Tìm kiếm sản phẩm..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                className="search-field"
                            />
                            <button type="submit" className="search-btn">
                                <FaSearch />
                            </button>
                        </form>
                    </div>
                </div>

                <div className="banner-section">
                    <Banner />
                </div>

                <div className="content-container">
                    <div className="contained-section">
                        <Section1 />
                    </div>
                    <div className="contained-section">
                        <Seed />
                    </div>
                    <div className="contained-section">
                        <Chat />
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Home