<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;

class ProductCategory extends Component
{
    public $slug;

    public function __construct($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        // Lấy danh mục dựa trên slug
        $category = Category::where('slug', $this->slug)->first();

        return view('frontend.product-category', [
            'category' => $category,
            'products' => new HomeProductCategory($category)
        ]);
    }
} 