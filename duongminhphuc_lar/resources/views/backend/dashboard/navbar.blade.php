<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <h3 class="text-xl font-semibold text-gray-800">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-6 mr-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 0 1-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 1 1-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 0 1 6.336-4.486l-3.276 3.276a3.004 3.004 0 0 0 2.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008Z" />
                        </svg>
                        Quản Lý Admin
                    </a>
                </h3>
            </div>

            <div class="flex items-center">
                <button id="sidebar-toggle" class="p-2 rounded-md text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-bars"></i>
                </button>
                
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-gray-600 hover:text-gray-900">Home</a>
                <a href="{{ route('admin.contact.index') }}" class="px-3 py-2 text-gray-600 hover:text-gray-900">Contact</a>

                <div class="relative ml-3">
                    <div class="user-info flex items-center">
                        @auth
                            <div class="flex items-center">
                                <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100 mr-2">
                                    <svg class="h-full w-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z" />
                                    </svg>
                                </span>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900">{{ session('username') }}</span>
                                    <span class="text-xs text-gray-500">{{ session('roles') }}</span>
                                </div>
                                <a href="{{ route('admin.logout') }}" class="ml-4 px-3 py-1 text-sm text-red-600 hover:text-red-800 hover:underline">
                                    Đăng Xuất
                                </a>
                            </div>
                        @else
                            <a href="{{ route('admin.login') }}" class="text-gray-600 hover:text-gray-900">Đăng Nhập</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav> 