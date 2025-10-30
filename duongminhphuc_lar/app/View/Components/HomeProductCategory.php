<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;
use App\Models\Product;

class HomeProductCategory extends Component
{
    public $category_item;

    public function __construct($categoryitem)
    {
        $this->category_item = $categoryitem;
    }

    public function render()
    {
        $list_catid = [];
        $category = $this->category_item;

        // Lấy danh mục cấp 1
        $args1 = [
            ['status', '=', '1'],
            ['parent_id', '=', $category->id],
        ];
        array_push($list_catid, $category->id);
        $categorys1 = Category::where($args1)->get();

        // Lấy danh mục cấp 2
        $subcategories = Category::where('parent_id', $category->id)->where('status', 1)->get();

        // Lấy sản phẩm thuộc các danh mục và phân trang
        $products = Product::where('status', '=', 1)
            ->whereIn('category_id', $list_catid)
            ->orderBy('created_at', 'DESC')
            ->paginate(8);

        return view('frontendz.product-category', compact('products', 'subcategories', 'category'));
    }
} 