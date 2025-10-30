<nav>
    <ul class="flex flex-col">
        @foreach ($menus as $menuitem)
            <li class="mb-2">
                <a class="text-gray-600 hover:text-gray-900 transition-colors duration-200" 
                   href="{{ url($menuitem->link) }}">
                    {{ $menuitem->name }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>