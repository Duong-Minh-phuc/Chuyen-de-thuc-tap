<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Menu;

class MainMenu extends Component
{
    public function render(): View|Closure|string
    {
        $args = [
            ['status', '=', 1],
            ['position', '=', 'mainmenu'],
            ['parent_id', '=', 0]
        ];
        $menus = Menu::where($args)->orderBy('sort_order', 'DESC')->get();

        return view('components.main-menu', compact('menus'));
    }
}
