<x-layout-admin>
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Chi tiết Người dùng</h2>
                <div>
                    <a href="{{ route('admin.user.edit', ['user' => $users->id]) }}" 
                        class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-flex items-center">
                        <i class="fa-solid fa-edit mr-2"></i>
                        Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.user.delete', ['user' => $users->id]) }}" class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600 inline-flex items-center">
                        <i class="fa-solid fa-trash mr-2"></i>
                        Thùng rác
                    </a>
                    <a href="{{ route('admin.user.index') }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-flex items-center">
                        <i class="fa-sharp fa-solid fa-arrow-rotate-left" style="color: #f5f8f9;"></i>
                        Về danh sách
                    </a>
                </div>
            </div>
        </div>

        <div class="p-4">
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr>
                        <th class="w-48 px-4 py-2 bg-gray-50 text-left">Thuộc tính</th>
                        <th class="px-4 py-2 bg-gray-50 text-left">Giá trị</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Id</td>
                        <td class="px-4 py-2">{{ $users->id }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">FullName</td>
                        <td class="px-4 py-2">{{ $users->fullname }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Gender</td>
                        <td class="px-4 py-2">{{ $users->gender }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">UserName</td>
                        <td class="px-4 py-2">{{ $users->username }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Email</td>
                        <td class="px-4 py-2">{{ $users->email }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Phone</td>
                        <td class="px-4 py-2">{{ $users->phone }}</td>
                    </tr>
                   
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Address</td>
                        <td class="px-4 py-2">{{ $users->address }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Image</td>
                        <td class="px-4 py-2">
                            <img src="{{ asset('images/user/' . $users->thumbnail) }}" 
                                alt="{{ $users->name }}"
                                class="max-w-xs">
                        </td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Role</td>
                        <td class="px-4 py-2">{{ $users->roles }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Created By</td>
                        <td class="px-4 py-2">{{ $users->created_by }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Updated By</td>
                        <td class="px-4 py-2">{{ $users->updated_by }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Created At</td>
                        <td class="px-4 py-2">{{ $users->created_at }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Updated At</td>
                        <td class="px-4 py-2">{{ $users->updated_at }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Status</td>
                        <td class="px-4 py-2">{{ $users->status }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layout-admin>
