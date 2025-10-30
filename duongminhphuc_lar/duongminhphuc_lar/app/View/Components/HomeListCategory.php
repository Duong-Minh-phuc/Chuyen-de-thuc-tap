<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;

class HomeListCategory extends Component
{
    public function render()
    {
        $args = [
            ['status', '=', '1'],    // Lấy các danh mục có status = 1 (đang hoạt động)
            ['parent_id', '=', 0],   // Lấy danh mục cha (parent_id = 0)
        ];

        $categorys = Category::where($args)
                           ->orderBy('sort_order', 'DESC')  // Sắp xếp theo sort_order giảm dần
                           ->get();

        return view('components.home-list-category', compact('categorys'));
    }
} 