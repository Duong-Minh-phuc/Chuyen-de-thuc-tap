import React, { createContext, useState, useContext, useEffect } from 'react';

const CartContext = createContext();

export const useCart = () => {
    return useContext(CartContext);
};

export const CartProvider = ({ children }) => {
    const [cartItems, setCartItems] = useState(() => {
        const savedCart = localStorage.getItem('cartItems');
        return savedCart ? JSON.parse(savedCart) : [];
    });

    const [totalItems, setTotalItems] = useState(0);

    useEffect(() => {
        // Cập nhật tổng số lượng mỗi khi cartItems thay đổi
        const total = cartItems.reduce((sum, item) => sum + item.quantity, 0);
        setTotalItems(total);
        
        // Lưu vào localStorage
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
    }, [cartItems]);

    const addToCart = (product, quantity = 1) => {
        setCartItems(prevItems => {
            const existingItem = prevItems.find(item => item.id === product.id);
            
            if (existingItem) {
                return prevItems.map(item =>
                    item.id === product.id
                        ? { ...item, quantity: item.quantity + quantity }
                        : item
                );
            }
            
            return [...prevItems, {
                id: product.id,
                name: product.name,
                price: product.price_sale || product.price_buy,
                thumbnail: product.thumbnail,
                quantity: quantity
            }];
        });
    };

    const updateQuantity = (productId, newQuantity) => {
        if (newQuantity < 1) return;
        
        setCartItems(prevItems =>
            prevItems.map(item =>
                item.id === productId
                    ? { ...item, quantity: newQuantity }
                    : item
            )
        );
    };

    const removeFromCart = (productId) => {
        setCartItems(prevItems => prevItems.filter(item => item.id !== productId));
    };

    const clearCart = () => {
        setCartItems([]);
        localStorage.removeItem('cartItems');
    };

    const getCartTotal = () => {
        return cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
    };

    return (
        <CartContext.Provider value={{
            cartItems,
            totalItems,
            addToCart,
            updateQuantity,
            removeFromCart,
            clearCart,
            getCartTotal
        }}>
            {children}
        </CartContext.Provider>
    );
};