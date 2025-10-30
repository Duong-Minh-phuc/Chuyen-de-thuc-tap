
<x-layout-admin>
    <div class="bg-white rounded-lg shadow-md">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <div class="p-4 bcontact-b bcontact-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Thùng Rác Liên Hệ</h2>
                <div class="space-x-2">
                    <a href="{{ route('admin.contact.index') }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 inline-flex items-center">
                        <i class="fa-sharp fa-solid fa-arrow-rotate-left" style="color: #f5f8f9;"></i>
                        Về danh sách
                    </a>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="p-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-12 px-4 py-3 text-center">#</th>
                      
                        <th class="px-4 py-3 text-left">Tên</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Phone</th>
                        <th class="px-4 py-3 text-left">Tiêu Đề</th>
                        <th class="px-4 py-3 text-left">Nội Dung </th>
                        <th class="px-4 py-3 text-left">Ngày Gởi </th>
                        <th class="w-48 px-4 py-3 text-center">Chức năng</th>
                        <th class="w-20 px-4 py-3 text-center">ID</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($contacts as $contact)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" class="rounded bcontact-gray-300">
                        </td>
                        
                        <td class="px-4 py-3">{{ $contact->name }}</td>
                        <td class="px-4 py-3">{{ $contact->email }}</td>
                        <td class="px-4 py-3">{{ $contact->phone }}</td>
                        <td class="px-4 py-3">{{ $contact->title }}</td>
                        <td class="px-4 py-3">{{ $contact->content }}</td>
                        <td class="px-4 py-3">{{ $contact->created_at }}</td>
         
                        <td class="px-4 py-3 text-center space-x-2">
                            <a href="{{ route('admin.contact.restore', ['contact' => $contact->id]) }}" 
                                class="inline-flex p-1 bg-blue-600 text-white rounded hover:opacity-75">
                                <i class="fa-sharp fa-solid fa-arrow-rotate-left"></i>
                            </a>                
                            <form action="{{ route('admin.contact.destroy', ['contact'=>$contact->id])}}" class="inline" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 py-1 px-1.5 text-white mx-0.5">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-center">{{ $contact->id }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4 bcontact-t bcontact-gray-200">
            {{ $contacts->links() }}
        </div>
    </div>
</x-layout-admin>
