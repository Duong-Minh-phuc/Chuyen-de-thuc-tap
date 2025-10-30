<?php

namespace App\View\Components;
use App\Models\Product;
use Illuminate\View\Component;

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

namespace App\View\Components;

use App\Models\Product;
use Illuminate\View\Component;

class AllProduct extends Component
{
    public function render()
    {
        // Lấy giá trị `sort` và `view` từ request
        $sort = request()->get('sort', 'created_at');
        $direction = request()->get('direction', $sort === 'price_buy_desc' ? 'DESC' : 'ASC');
        $view = request()->get('view', 'grid');
    
        if ($sort === 'price_buy_desc') {
            $sort = 'price_buy';
        }
    
        // Truy vấn sản phẩm
        $products = Product::where('status', 1)
            ->orderBy($sort, $direction)
            ->paginate(8);
    
        return view('components.all-product', compact('products', 'view', 'sort'));
    }
    
}
