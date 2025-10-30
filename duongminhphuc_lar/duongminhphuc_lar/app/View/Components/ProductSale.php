<?php

namespace App\View\Components;
use App\Models\Product;
use Illuminate\View\Component;

class ProductSale extends Component
{
    public function render()
    {
        // Lấy sản phẩm có giá sale
        $products = Product::where('status', 1)
                         ->where('price_sale', '>', 0)
                         ->orderBy('created_at', 'DESC')
                         ->limit(4)
                         ->get();
                         
        return view('components.product-sale', compact('products'));
    }
} 