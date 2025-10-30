<x-layout-admin>
    <x-slot:title>
        Chỉnh sửa Người dùng
    </x-slot>
    <div>
        <form action="{{ route('admin.user.update', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex justify-between items-start mb-3 p-3 gap-5 rounded-md border">
                <h3 class="text-xl font-bold text-gray-900">Chỉnh sửa Người dùng</h3>
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
                            value="{{ old('fullname', $user->fullname) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('fullname'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('fullname') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="username" class="block text-base font-medium text-gray-600">
                            Tên đăng nhập <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="username"
                            name="username"
                            value="{{ old('username', $user->username) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('username'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('username') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-base font-medium text-gray-600">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('email'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-base font-medium text-gray-600">
                            Điện thoại <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="phone"
                            name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('phone'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('phone') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-base font-medium text-gray-600">
                            Địa chỉ <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="address"
                            name="address"
                            value="{{ old('address', $user->address) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('address'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('address') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="thumbnail" class="block text-base font-medium text-gray-600">
                            Hình ảnh
                        </label>
                        <input type="file" 
                            id="thumbnail"
                            name="thumbnail"
                            class="mt-1 block w-full">
                        @if ($errors->has('thumbnail'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('thumbnail') }}</div>
                        @endif
                        @if($user->thumbnail)
                            <div class="mt-2">
                                <img src="{{ asset('images/user/'.$user->thumbnail) }}" alt="Current Image" class="w-32 h-32 object-cover">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-span-1 bg-white p-4 rounded-md shadow">
                    <div class="mb-4">
                        <label for="roles" class="block text-base font-medium text-gray-600">
                            Quyền <span class="text-red-500">*</span>
                        </label>
                        <select id="roles"
                            name="roles"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            <option value="user" {{ $user->roles == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->roles == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-base font-medium text-gray-600">
                            Trạng thái
                        </label>
                        <select id="status"
                            name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            <option value="2" {{ $user->status == 2 ? 'selected' : '' }}>Chưa kích hoạt</option>
                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layout-admin>
