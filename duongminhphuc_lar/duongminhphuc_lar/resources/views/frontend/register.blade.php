<x-layout-site>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-2xl font-bold text-gray-700 mb-4 text-center">Đăng Ký</h1>
            <form action="{{ route('site.doregister') }}" method="post">
                @csrf 
                
                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-600 mb-1">
                        Tên đăng nhập
                    </label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                        placeholder="Nhập tên đăng nhập"
                        required
                    />
                </div>

                <!-- Email Field -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-600 mb-1">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                        placeholder="Nhập email"
                        required
                    />
                </div>

                <!-- Password Field -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-600 mb-1">
                        Mật khẩu
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                        placeholder="Nhập mật khẩu"
                        required
                    />
                </div>

                <!-- Confirm Password Field -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600 mb-1">
                        Xác nhận mật khẩu
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                        placeholder="Xác nhận mật khẩu"
                        required
                    />
                </div>

                <!-- Error Message -->
                @if($errors->any())
                    <div class="mt-4">
                        <ul class="text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 mt-4"
                >
                    Đăng Ký
                </button>
            </form>

            <!-- Login Link -->
            <p class="mt-4 text-center text-sm text-gray-600">
                Bạn đã có tài khoản? 
                <a href="{{ route('site.login') }}" class="text-blue-500 hover:underline">Đăng nhập</a>
            </p>
        </div>
    </div>
</x-layout-site> 