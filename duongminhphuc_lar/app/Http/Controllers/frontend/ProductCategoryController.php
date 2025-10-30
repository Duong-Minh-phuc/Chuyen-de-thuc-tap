<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductCategoryController extends Controller
{
    public function index($slug)
    {
        // Lấy giá trị sort, direction, view từ request
        $sort = request()->get('sort', 'created_at');
        $direction = request()->get('direction', $sort === 'price_buy_desc' ? 'DESC' : 'ASC');
        $view = request()->get('view', 'grid');

        if ($sort === 'price_buy_desc') {
            $sort = 'price_buy';
        }

        // Lấy danh mục theo slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Lấy danh sách sản phẩm
        $products = Product::where('category_id', $category->id)
            ->where('status', 1)
            ->orderBy($sort, $direction)
            ->paginate(2);

        return view('frontend.product-category', [
            'category' => $category,
            'products' => $products,
            'view' => $view,
        ]);
    }
}
