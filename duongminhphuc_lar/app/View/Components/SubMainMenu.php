<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Menu;
use Illuminate\View\View;
use Closure;

class SubMainMenu extends Component
{
    public $menu_item;
    public function __construct($menuitem)
    {
        $this->menu_item = $menuitem;
    }

    public function render(): View|Closure|string
    {
        $menu = $this->menu_item;
        $args = [
            ['status', '=', 1],
            ['position', '=', 'mainmenu'],
            ['parent_id', '=', $menu->id]
        ];
        $menus = Menu::where($args)->orderBy('sort_order', 'DESC')->get();
        return view('components.sub-main-menu', compact('menus', 'menu'));
    }
}
