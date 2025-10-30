"use client"

import { useEffect, useState } from "react"
import Image from "next/image"
import { Star, Heart, ShoppingCart, Eye, Filter } from "lucide-react"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { fetchProducts, type Product } from "@/services/api"
import { toast } from "sonner"
import React from "react"

export default function ProductsPage() {
  const [products, setProducts] = useState<Product[]>([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)
  const [currentPage, setCurrentPage] = useState(1)
  const [totalPages, setTotalPages] = useState(0)
  const [sortBy, setSortBy] = useState("newest")
  const [priceRange, setPriceRange] = useState("all")
  const [hoveredProduct, setHoveredProduct] = useState<number | null>(null)

  useEffect(() => {
    loadProducts()
  }, [currentPage, sortBy, priceRange])

  const loadProducts = async () => {
    try {
      setLoading(true)
      const response = await fetchProducts(currentPage, priceRange)
      
      if (response.data) {
        let sortedProducts = [...response.data.data]

        // Sort products based on selection
        if (sortBy === "price_low") {
          sortedProducts.sort((a, b) => (a.price_sale || a.price_buy) - (b.price_sale || b.price_buy))
        } else if (sortBy === "price_high") {
          sortedProducts.sort((a, b) => (b.price_sale || b.price_buy) - (a.price_sale || a.price_buy))
        }

        setProducts(sortedProducts)
        setTotalPages(response.data.last_page)
      }
    } catch (err) {
      setError('Không thể tải sản phẩm. Vui lòng thử lại sau.')
      toast.error('Không thể tải sản phẩm')
    } finally {
      setLoading(false)
    }
  }

  const formatPrice = (price: number) => {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    }).format(price)
  }

  const calculateDiscount = (originalPrice: number, salePrice: number) => {
    return Math.round(((originalPrice - salePrice) / originalPrice) * 100)
  }

  const renderStars = (rating: number = 0) => {
    const stars = []
    const fullStars = Math.floor(rating)
    const hasHalfStar = rating % 1 !== 0

    for (let i = 0; i < 5; i++) {
      if (i < fullStars) {
        stars.push(<Star key={i} className="w-4 h-4 fill-yellow-400 text-yellow-400" />)
      } else if (i === fullStars && hasHalfStar) {
        stars.push(<Star key={i} className="w-4 h-4 fill-yellow-400/50 text-yellow-400" />)
      } else {
        stars.push(<Star key={i} className="w-4 h-4 text-gray-300" />)
      }
    }
    return stars
  }

  const handleSort = (value: string) => {
    setSortBy(value)
    setCurrentPage(1) // Reset về trang 1 khi sắp xếp lại
  }

  const handlePriceRange = (value: string) => {
    setPriceRange(value)
    setCurrentPage(1) // Reset về trang 1 khi lọc giá
  }

  const handlePageChange = (page: number) => {
    setCurrentPage(page)
    window.scrollTo({ top: 0, behavior: "smooth" })
  }

  const handleAddToCart = (product: Product) => {
    // Lấy giỏ hàng từ localStorage
    const existingCart = JSON.parse(localStorage.getItem('cart') || '[]')
    
    // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
    const existingProductIndex = existingCart.findIndex((item: any) => item.id === product.id)
    
    if (existingProductIndex >= 0) {
      // Nếu sản phẩm đã tồn tại, tăng số lượng
      existingCart[existingProductIndex].quantity += 1
    } else {
      // Nếu sản phẩm chưa tồn tại, thêm mới với số lượng 1
      existingCart.push({
        ...product,
        quantity: 1
      })
    }
    
    // Lưu giỏ hàng đã cập nhật vào localStorage
    localStorage.setItem('cart', JSON.stringify(existingCart))
    
    toast.success('Sản phẩm đã được thêm vào giỏ hàng')
  }

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-rose-500 mx-auto mb-4"></div>
          <p className="text-gray-600">Đang tải sản phẩm...</p>
        </div>
      </div>
    )
  }

  if (error) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <p className="text-red-600 mb-4">{error}</p>
          <Button onClick={() => loadProducts()} variant="outline">
            Thử lại
          </Button>
        </div>
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 className="text-3xl font-bold text-gray-900">Tất Cả Sản Phẩm</h1>
              <p className="text-gray-600 mt-1">Khám phá bộ sưu tập nước hoa cao cấp</p>
            </div>

            <div className="flex items-center gap-4">
              <div className="flex items-center gap-2">
                <Filter className="w-4 h-4 text-gray-500" />
                <span className="text-sm text-gray-600">Lọc & Sắp xếp:</span>
              </div>
              <Select value={sortBy} onValueChange={handleSort}>
                <SelectTrigger className="w-48">
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="newest">Mới nhất</SelectItem>
                  <SelectItem value="price-low">Giá thấp đến cao</SelectItem>
                  <SelectItem value="price-high">Giá cao đến thấp</SelectItem>
                  <SelectItem value="rating">Đánh giá cao nhất</SelectItem>
                </SelectContent>
              </Select>

              <Select value={priceRange} onValueChange={handlePriceRange}>
                <SelectTrigger className="w-48">
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">Tất cả giá</SelectItem>
                  <SelectItem value="0-1000000">Dưới 1 triệu</SelectItem>
                  <SelectItem value="1000000-3000000">1 triệu - 3 triệu</SelectItem>
                  <SelectItem value="3000000-5000000">3 triệu - 5 triệu</SelectItem>
                  <SelectItem value="5000000-10000000">5 triệu - 10 triệu</SelectItem>
                  <SelectItem value="10000000">Trên 10 triệu</SelectItem>
                </SelectContent>
              </Select>
            </div>
          </div>
        </div>
      </div>

      {/* Products Grid */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {products.length > 0 ? (
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {products.map((product) => (
              <div
                key={product.id}
                className="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group"
                onMouseEnter={() => setHoveredProduct(product.id)}
                onMouseLeave={() => setHoveredProduct(null)}
              >
                {/* Product Image */}
                <div className="relative aspect-square overflow-hidden bg-gray-50">
                  <Image
                    src={`http://127.0.0.1:8000/images/product/${product.thumbnail}`}
                    alt={product.name}
                    fill
                    className="object-contain p-4 group-hover:scale-105 transition-transform duration-300"
                    onError={(e: any) => {
                      e.target.src = "/placeholder.svg"
                    }}
                  />

                  {/* Discount Badge */}
                  {product.price_sale > 0 && (
                    <Badge className="absolute top-3 right-3 bg-rose-500 hover:bg-rose-600 text-white font-semibold">
                      -{calculateDiscount(product.price_buy, product.price_sale)}%
                    </Badge>
                  )}

                  {/* Quick Actions */}
                  <div
                    className={`absolute inset-0 bg-black/20 flex items-center justify-center gap-2 transition-opacity duration-300 ${
                      hoveredProduct === product.id ? "opacity-100" : "opacity-0"
                    }`}
                  >
                    <Button size="sm" variant="secondary" className="bg-white/90 hover:bg-white">
                      <Eye className="w-4 h-4" />
                    </Button>
                    <Button size="sm" variant="secondary" className="bg-white/90 hover:bg-white">
                      <Heart className="w-4 h-4" />
                    </Button>
                    <Button size="sm" variant="secondary" className="bg-white/90 hover:bg-white">
                      <ShoppingCart className="w-4 h-4" />
                    </Button>
                  </div>
                </div>

                {/* Product Info */}
                <div className="p-4 space-y-3">
                  {/* Brand */}
                  <div className="flex items-center justify-between">
                    <Badge variant="outline" className="text-xs font-medium text-gray-600">
                      {product.brand_name}
                    </Badge>

                    {/* Rating */}
                    <div className="flex items-center gap-1">
                      <div className="flex items-center">{renderStars(product.averageRating)}</div>
                      <span className="text-xs text-gray-500">({product.totalReviews || 0})</span>
                    </div>
                  </div>

                  {/* Product Name */}
                  <h3 className="font-semibold text-gray-900 line-clamp-2 leading-tight">{product.name}</h3>

                  {/* Product Content/Description */}
                  <p className="text-sm text-gray-600 line-clamp-2 leading-relaxed">{product.content}</p>

                  {/* Price */}
                  <div className="flex items-center gap-2">
                    {product.price_sale > 0 ? (
                      <>
                        <span className="text-lg font-bold text-rose-600">{formatPrice(product.price_sale)}</span>
                        <span className="text-sm text-gray-500 line-through">{formatPrice(product.price_buy)}</span>
                      </>
                    ) : (
                      <span className="text-lg font-bold text-gray-900">{formatPrice(product.price_buy)}</span>
                    )}
                  </div>

                  {/* Add to Cart Button */}
                  <Button 
                    className="w-full bg-rose-600 hover:bg-rose-700 text-white"
                    onClick={() => handleAddToCart(product)}
                  >
                    <ShoppingCart className="w-4 h-4 mr-2" />
                    Thêm vào giỏ
                  </Button>
                </div>
              </div>
            ))}
          </div>
        ) : (
          <div className="text-center py-5">
            <ShoppingCart size={48} className="text-muted mb-3 opacity-50 mx-auto" />
            <h3 className="text-lg font-semibold mb-2">Không tìm thấy sản phẩm</h3>
            <p className="text-gray-600">Không có sản phẩm nào phù hợp với bộ lọc của bạn.</p>
          </div>
        )}

        {/* Pagination */}
        {totalPages > 1 && (
          <div className="flex justify-center items-center gap-2 mt-12">
            <Button
              variant="outline"
              disabled={currentPage === 1}
              onClick={() => handlePageChange(currentPage - 1)}
            >
              Trước
            </Button>

            {[...Array(totalPages)].map((_, index) => {
              const page = index + 1
              if (
                page === 1 ||
                page === totalPages ||
                (page >= currentPage - 1 && page <= currentPage + 1)
              ) {
                return (
                  <Button
                    key={page}
                    variant={currentPage === page ? "default" : "outline"}
                    className={currentPage === page ? "bg-rose-600 hover:bg-rose-700" : ""}
                    onClick={() => handlePageChange(page)}
                  >
                    {page}
                  </Button>
                )
              } else if (page === currentPage - 2 || page === currentPage + 2) {
                return (
                  <span key={page} className="px-2 text-gray-400">
                    ...
                  </span>
                )
              }
              return null
            })}

            <Button
              variant="outline"
              disabled={currentPage === totalPages}
              onClick={() => handlePageChange(currentPage + 1)}
            >
              Sau
            </Button>
          </div>
        )}
      </div>
    </div>
  )
} 