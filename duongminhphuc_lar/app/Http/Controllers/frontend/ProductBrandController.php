<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;

class ProductBrandController extends Controller
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
        $brand = Brand::where('slug', $slug)->firstOrFail();

        // Lấy danh sách sản phẩm
        $products = Product::where('brand_id', $brand->id)
            ->where('status', 1)
            ->orderBy($sort, $direction)
            ->paginate(2);

        return view('frontend.product-brand', [
            'brand' => $brand,
            'products' => $products,
            'view' => $view,
        ]);
    }
}
