<?php

namespace App\View\Components;
use App\Models\Product;
use Illuminate\View\Component;

class ProductCard extends Component
{
    public $product_item;

    public function __construct($productitem)
    {
        $this->product_item = $productitem;
    }

    public function render()
    {
        $product = $this->product_item;
        return view('components.product-card', compact('product'));
    }
}
