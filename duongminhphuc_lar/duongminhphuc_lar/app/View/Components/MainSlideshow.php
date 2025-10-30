<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Banner;

class MainSlideshow extends Component
{
    public $banners;

    public function __construct()
    {
        $this->banners = Banner::where('position', 'slideshow')
                              ->where('status', 1)
                              ->orderBy('sort_order', 'asc')
                              ->limit(3)
                              ->get();
    }

    public function render()
    {
        return view('components.main-slideshow');
    }
} 