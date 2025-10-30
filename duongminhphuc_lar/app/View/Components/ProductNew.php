<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product;

class ProductNew extends Component
{
    public function render()
    {
        // Lấy sản phẩm mới
        $products = Product::where('status', 1)
                         ->orderBy('created_at', 'DESC')
                         ->limit(4)
                         ->get();
                         
        return view('components.product-new', compact('products'));
    }
}