<x-layout-admin>
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Chi tiết Liên hệ</h2>
                <div>
                    <a href="{{ route('admin.contact.edit', ['contact' => $contacts->id]) }}" 
                        class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-flex items-center">
                        <i class="fa-solid fa-edit mr-2"></i>
                        Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.contact.delete', ['contact' => $contacts->id]) }}" class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600 inline-flex items-center">
                        <i class="fa-solid fa-trash mr-2"></i>
                        Thùng rác
                    </a>
                    <a href="{{ route('admin.contact.index') }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-flex items-center">
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
                        <td class="px-4 py-2">{{ $contacts->id }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Tên người liên hệ</td>
                        <td class="px-4 py-2">{{ $contacts->name }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Email</td>
                        <td class="px-4 py-2">{{ $contacts->email }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Phone</td>
                        <td class="px-4 py-2">{{ $contacts->phone }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Title</td>
                        <td class="px-4 py-2">{{ $contacts->title }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Content</td>
                        <td class="px-4 py-2">{{ $contacts->content }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Replay id</td>
                        <td class="px-4 py-2">{{ $contacts->replay_id }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Created by</td>
                        <td class="px-4 py-2">{{ $contacts->created_by }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Updated by</td>
                        <td class="px-4 py-2">{{ $contacts->updated_by }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Created at</td>
                        <td class="px-4 py-2">{{ $contacts->created_at }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Updated at</td>
                        <td class="px-4 py-2">{{ $contacts->updated_at }}</td>
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2 bg-gray-50">Status</td>
                        <td class="px-4 py-2">{{ $contacts->status }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layout-admin>
