<div>
    @if (count($menus) > 0)
        <li class="relative group">
            <a class="text-gray-800 hover:text-gray-600 inline-block px-4 py-3 text-[17px] font-semibold uppercase tracking-wider" 
               href="{{ url($menu->link) }}">
                {{ $menu->name }}
            </a>
            <ul class="transition-all duration-700 ease-in-out absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 bg-white shadow-lg min-w-[220px] z-50">
                @foreach ($menus as $item)
                    <li class="group">
                        <a class="text-gray-600 hover:text-gray-800 hover:bg-gray-50 block px-4 py-3 text-[17px] font-medium capitalize transition-colors duration-200" 
                           href="{{ url($item->link) }}">
                            {{ $item->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @else
        <li class="relative group">
            <a class="text-gray-800 hover:text-gray-600 inline-block px-4 py-3 text-[16px] font-semibold uppercase tracking-wider" 
               href="{{ url($menu->link) }}">
                {{ $menu->name }}
            </a>
        </li>
    @endif
</div>