<x-layout-admin>
    <x-slot:title>
        Chỉnh sửa Liên hệ
    </x-slot>
    <div>
        <form action="{{ route('admin.contact.update', ['contact' => $contact->id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="flex justify-between items-start mb-3 p-3 gap-5 rounded-md border">
                <h3 class="text-xl font-bold text-gray-900">Chỉnh sửa Liên hệ</h3>
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Lưu
                    </button>
                    <a href="{{ route('admin.contact.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Quay lại
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-5">
                <div class="col-span-2 bg-white p-4 rounded-md shadow">
                    <div class="mb-4">
                        <label for="name" class="block text-base font-medium text-gray-600">
                            Họ tên <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="name"
                            name="name"
                            value="{{ old('name', $contact->name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('name'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('name') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-base font-medium text-gray-600">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                            id="email"
                            name="email"
                            value="{{ old('email', $contact->email) }}"
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
                            value="{{ old('phone', $contact->phone) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('phone'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('phone') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-base font-medium text-gray-600">
                            Tiêu đề <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="title"
                            name="title"
                            value="{{ old('title', $contact->title) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('title'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('title') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-base font-medium text-gray-600">
                            Nội dung <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="content"
                            name="content"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">{{ old('content', $contact->content) }}</textarea>
                        @if ($errors->has('content'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('content') }}</div>
                        @endif
                    </div>
                </div>

                <div class="col-span-1 bg-white p-4 rounded-md shadow">
                    <div>
                        <label for="status" class="block text-base font-medium text-gray-600">
                            Trạng thái
                        </label>
                        <select id="status"
                            name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            <option value="2" {{ $contact->status == 2 ? 'selected' : '' }}>Chưa xử lý</option>
                            <option value="1" {{ $contact->status == 1 ? 'selected' : '' }}>Đã xử lý</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layout-admin>
