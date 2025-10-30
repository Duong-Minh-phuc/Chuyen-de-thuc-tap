<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Menu;

class FooterMenu extends Component
{
    public $menus;

    public function __construct()
    {
        $args = [
            ['status', '=', 1],
            ['position', '=', 'footermenu'],
            ['parent_id', '=', 0]
        ];
        $this->menus = Menu::where($args)->orderBy('sort_order', 'DESC')->get();
    }

    public function render()
    {
        return view('components.footer-menu');
    }
}
