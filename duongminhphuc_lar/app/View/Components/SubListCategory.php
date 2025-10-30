<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;

class SubListCategory extends Component
{
    public $category_id;

    public function __construct($categoryid)
    {
        $this->category_id = $categoryid;
    }

    public function render()
    {
        $catid = $this->category_id;
        $args = [
            ['status', '=', '1'],
            ['parent_id', '=', $catid],
        ];

        $category_list = Category::where($args)
                               ->orderBy('sort_order', 'DESC')
                               ->get();

        return view('components.sub-list-category', compact('category_list'));
    }
} 