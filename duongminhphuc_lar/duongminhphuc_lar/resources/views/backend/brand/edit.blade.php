<x-layout-admin>
    <x-slot:title>
        Chỉnh sửa Thương hiệu
    </x-slot>
    <div>
        <form action="{{ route('admin.brand.update', ['brand' => $brand->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex justify-between items-start mb-3 p-3 gap-5 rounded-md border">
                <h3 class="text-xl font-bold text-gray-900">Chỉnh sửa Thương hiệu</h3>
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Lưu
                    </button>
                    <a href="{{ route('admin.brand.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Quay lại
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-5">
                <div class="col-span-2 bg-white p-4 rounded-md shadow">
                    <div class="mb-4">
                        <label for="name" class="block text-base font-medium text-gray-600">
                            Tên thương hiệu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="name"
                            name="name"
                            value="{{ old('name', $brand->name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('name'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('name') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="slug" class="block text-base font-medium text-gray-600">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="slug"
                            name="slug"
                            value="{{ old('slug', $brand->slug) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('slug'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('slug') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-base font-medium text-gray-600">
                            Mô tả
                        </label>
                        <textarea 
                            id="description"
                            name="description"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">{{ old('description', $brand->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-base font-medium text-gray-600">
                            Hình ảnh <span class="text-red-500">*</span>
                        </label>
                        <input type="file" 
                            id="image"
                            name="image"
                            class="mt-1 block w-full">
                        @if ($errors->has('image'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('image') }}</div>
                        @endif
                        @if($brand->image)
                            <div class="mt-2">
                                <img src="{{ asset('images/brand/'.$brand->image) }}" alt="Current Image" class="w-32 h-32 object-cover">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-span-1 bg-white p-4 rounded-md shadow">
                    <div>
                        <label for="sort_order" class="block text-base font-medium text-gray-600">
                            Sắp xếp <span class="text-red-500">*</span>
                        </label>
                        <select id="sort_order"
                            name="sort_order"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            @foreach($brands as $item)
                                <option value="{{ $item->id }}" {{ $brand->sort_order == $item->id ? 'selected' : '' }}>
                                    Sau: {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-base font-medium text-gray-600">
                            Trạng thái
                        </label>
                        <select id="status"
                            name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            <option value="2" {{ $brand->status == 2 ? 'selected' : '' }}>Chưa xuất bản</option>
                            <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Xuất bản</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layout-admin>
