<nav class="flex justify-between  items-center bg-white shadow-sm">
    <ul class="flex items-center space-x-6">
        @foreach ($menus as $menuitem)
            @php
                \Log::info('Menu item:', ['item' => $menuitem->toArray()]);
            @endphp
            <x-sub-main-menu :menuitem="$menuitem" />
        @endforeach
    </ul>
    
    <!-- Mobile menu button -->
    <div class="md:hidden visible text-gray-800 p-4 hover:text-gray-600 cursor-pointer">
        <i class="fa-solid fa-bars-staggered text-xl"></i>
    </div>
</nav>

