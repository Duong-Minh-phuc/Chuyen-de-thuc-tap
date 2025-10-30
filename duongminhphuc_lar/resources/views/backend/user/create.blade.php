<x-layout-admin>
    <x-slot:title>
        Thêm mới Người dùng
    </x-slot>
    <div>
        <form action="{{ route('admin.user.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between items-start mb-3 p-3 gap-5 rounded-md border">
                <h3 class="text-xl font-bold text-gray-900">Quản Lí Người dùng</h3>
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Lưu
                    </button>
                    <a href="{{ route('admin.user.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Quay lại
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-5">
                <div class="col-span-2 bg-white p-4 rounded-md shadow">
                    <div class="mb-4">
                        <label for="fullname" class="block text-base font-medium text-gray-600">
                            Họ tên <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="fullname"
                            name="fullname"
                            value="{{ old('fullname') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('fullname'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('fullname') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-base font-medium text-gray-600">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('email'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-base font-medium text-gray-600">
                            Số điện thoại <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('phone'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('phone') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="username" class="block text-base font-medium text-gray-600">
                            Tên tài khoản <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('username'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('username') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-base font-medium text-gray-600">
                            Mật khẩu <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                            id="password"
                            name="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('password'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('password') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="thumbnail" class="block text-base font-medium text-gray-600">
                            Hình ảnh
                        </label>
                        <input type="file" 
                            id="thumbnail"
                            name="thumbnail"
                            class="mt-1 block w-full text-base text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100">
                        @if ($errors->has('thumbnail'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('thumbnail') }}</div>
                        @endif
                    </div>
                </div>

                <div class="bg-white p-4 rounded-md shadow space-y-4">
                    <div>
                        <label for="roles" class="block text-base font-medium text-gray-600">
                            Vai trò <span class="text-red-500">*</span>
                        </label>
                        <select id="roles"
                            name="roles"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            <option value="customer">Customer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-base font-medium text-gray-600">
                            Trạng thái
                        </label>
                        <select id="status"
                            name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            <option value="2">Chưa xuất bản</option>
                            <option value="1">Xuất bản</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layout-admin>
