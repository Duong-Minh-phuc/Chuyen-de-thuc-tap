<x-layout-admin>
    <x-slot:title>
        Thêm mới Banner
    </x-slot>
    <div>
        <form action="{{ route('admin.banner.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between items-start mb-3 p-3 gap-5 rounded-md border">
                <h3 class="text-xl font-bold text-gray-900">Thêm mới Banner</h3>
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Thêm
                    </button>
                    <a href="{{ route('admin.banner.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Quay lại
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-5">
                <div class="col-span-2 bg-white p-4 rounded-md shadow">
                    <div class="mb-4">
                        <label for="name" class="block text-base font-medium text-gray-600">
                            Tên Banner <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('name'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('name') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="link" class="block text-base font-medium text-gray-600">
                            Liên kết <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="link"
                            name="link"
                            value="{{ old('link') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('link'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('link') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-base font-medium text-gray-600">
                            Mô tả
                        </label>
                        <textarea 
                            id="description"
                            name="description"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-base font-medium text-gray-600">
                            Hình ảnh <span class="text-red-500">*</span>
                        </label>
                        <input type="file" 
                            id="image"
                            name="image"
                            class="mt-1 block w-full text-base text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100">
                        @if ($errors->has('image'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('image') }}</div>
                        @endif
                    </div>
                </div>

                <div class="bg-white p-4 rounded-md shadow space-y-4">
                    <div>
                        <label for="position" class="block text-base font-medium text-gray-600">
                            Vị trí <span class="text-red-500">*</span>
                        </label>
                        <select id="position"
                            name="position"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            @foreach($positions as $position)
                                <option value="{{ $position }}">{{ $position }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('position'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('position') }}</div>
                        @endif
                    </div>

                    <div>
                        <label for="sort_order" class="block text-base font-medium text-gray-600">
                            Sắp xếp <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                            id="sort_order"
                            name="sort_order"
                            value="{{ old('sort_order') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('sort_order'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('sort_order') }}</div>
                        @endif
                    </div>

                    <div>
                        <label for="status" class="block text-base font-medium text-gray-600">
                            Trạng thái
                        </label>
                        <select id="status"
                            name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            <option value="1">Xuất bản</option>
                            <option value="2">Chưa xuất bản</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layout-admin>
