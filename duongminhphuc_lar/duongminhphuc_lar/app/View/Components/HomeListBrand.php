<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Brand;

class HomeListBrand extends Component
{
    public function render()
    {
        $args = [
            ['status', '=', '1'],    // Lấy các thương hiệu có status = 1 (đang hoạt động)
        ];

        $brands = Brand::where($args)
                           ->orderBy('sort_order', 'DESC')  // Sắp xếp theo sort_order giảm dần
                           ->get();

        return view('components.home-list-brand', compact('brands'));
    }
} 