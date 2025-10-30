<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller 
{
    public function index()
    {
        return view('frontend.product');
    }

    public function detail($slug)
    {
        $product = Product::where('slug', $slug)
                         ->where('status', 1)
                         ->firstOrFail();

        // Lấy sản phẩm liên quan cùng danh mục
        $related_products = Product::where('status', 1)
                                 ->where('id', '!=', $product->id)
                                 ->where('category_id', $product->category_id)
                                 ->limit(4)
                                 ->get();

        return view('frontend.product-detail', compact('product', 'related_products'));
    }
}
