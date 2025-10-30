const API_BASE_URL = 'http://127.0.0.1:8000/api';

export interface Product {
  id: number;
  name: string;
  brand_name: string;
  content: string;
  price_buy: number;
  price_sale: number;
  thumbnail: string;
  slug: string;
  averageRating?: number;
  totalReviews?: number;
}

export interface PaginatedResponse<T> {
  current_page: number;
  data: T[];
  first_page_url: string;
  from: number;
  last_page: number;
  last_page_url: string;
  next_page_url: string | null;
  path: string;
  per_page: number;
  prev_page_url: string | null;
  to: number;
  total: number;
}

export interface ApiResponse<T> {
  data: PaginatedResponse<T>;
  message: string;
  status: number;
}

export const fetchProducts = async (
  page: number = 1,
  priceRange: string = 'all'
): Promise<ApiResponse<Product>> => {
  try {
    const params = new URLSearchParams({
      page: page.toString(),
      price_range: priceRange,
    });

    const response = await fetch(`${API_BASE_URL}/product?${params}`);
    if (!response.ok) {
      throw new Error('Failed to fetch products');
    }
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error fetching products:', error);
    throw error;
  }
}; 