<!-- File: header.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>

<header class="bg-white shadow-sm ">
   
       
   
    <div class="container  mx-auto px-4">
        
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="{{ asset('images/logon.webp') }}" alt="Logo" class="h-16  w-auto">
                </a>
            </div>
           
            <div class="menu-wrapper flex justify-center space-x-6">
                <x-main-menu />
            </div>
            

            <!-- Khoảng trống cho menu -->
            
            <!-- Tìm kiếm -->
           

            <!-- Giỏ hàng -->
            <div class="flex-shrink-0 relative">
                <a href="{{ route('site.cart') }}" 
                   class="flex items-center px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-gray-700 font-medium">Giỏ hàng</span>
                    
                    <!-- Hiển thị số lượng sản phẩm -->
                    @php
                        $cart = session()->get('cart', []);
                        $totalQuantity = array_sum(array_column($cart, 'qty'));
                    @endphp
                    @if($totalQuantity > 0)
                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1">
                            {{ $totalQuantity }}
                        </span>
                    @endif
                </a>
            </div>

            <!-- Hiển thị tên người dùng và đăng xuất -->
            <div class="flex items-center">
                @if(session('user_site'))
                    <span class="mr-2 text-gray-700">{{ session('user_site')->username }}</span>
                    <a href="{{ route('site.logout') }}" class="text-gray-600 hover:text-gray-900">Đăng Xuất</a>
                @else
                    <a href="{{ route('site.login') }}" class="text-gray-600 hover:text-gray-900 ml-5 text-xl">Đăng Nhập</a>
                @endif
            </div>
        </div>
    </div>
</header>

</body>
</html>
