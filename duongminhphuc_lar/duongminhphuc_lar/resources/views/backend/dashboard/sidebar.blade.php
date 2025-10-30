<aside class="w-64 bg-white shadow-md h-screen">
    <div class="p-4">
        <ul class="space-y-2">
            <li class="nav-section">
                <a href="#" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <i class="fab fa-product-hunt mr-2"></i>
                    <span>Sản phẩm</span>
                </a>
                <ul class="ml-4 mt-2 space-y-1">
                    <li><a href="{{ route('admin.product.index') }}" class="block p-2 text-gray-600 hover:text-gray-900">Tất cả sản phẩm</a></li>
                    <li><a href="{{ route('admin.category.index') }}" class="block p-2 text-gray-600 hover:text-gray-900">Danh mục</a></li>
                    <li><a href="{{ route('admin.brand.index') }}" class="block p-2 text-gray-600 hover:text-gray-900">Thương hiệu</a></li>
                </ul>
            </li>
            <li class="nav-section">
                <a href="#" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <i class="fa-solid fa-book"></i>
                    <span>Bài Viết</span>
                </a>
                <ul class="ml-4 mt-2 space-y-1">
                    <li><a href="{{ route('admin.post.index') }}" class="block p-2 text-gray-600 hover:text-gray-900">Tất cả Bài Viết</a></li>
                    <li><a href="{{ route('admin.topic.index') }}" class="block p-2 text-gray-600 hover:text-gray-900">Chủ Đề</a></li>
           
                </ul>
            </li>
            <li class="nav-section">
                <a href="#" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <i class="fa-sharp fa-solid fa-tv"></i>
                    <span>Giao diện</span>
                </a>
                <ul class="ml-4 mt-2 space-y-1">
                    <li><a href="{{ route('admin.menu.index') }}" class="block p-2 text-gray-600 hover:text-gray-900">Menu</a></li>
                    <li><a href="{{ route('admin.banner.index') }}" class="block p-2 text-gray-600 hover:text-gray-900">Banner</a></li>
           
                </ul>
            </li>
            <li class="nav-section">
                <a href="#" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <i class="fa-sharp fa-solid fa-address-card"></i>
                    <span>Mục Khác</span>
                </a>
                <ul class="ml-4 mt-2 space-y-1">
                    <li><a href="{{ route('admin.order.index') }}" class="block p-2 text-gray-600 hover:text-gray-900">Đơn Hàng</a></li>
                    <li><a href="{{ route('admin.contact.index') }}" class="block p-2 text-gray-600 hover:text-gray-900">Liên Hệ</a></li>
                    <li><a href="{{ route('admin.user.index') }}" class="block p-2 text-gray-600 hover:text-gray-900">User</a></li>
           
                </ul>
            </li>
            <!-- Thêm các mục menu khác tương tự -->
        </ul>
    </div>
</aside> 