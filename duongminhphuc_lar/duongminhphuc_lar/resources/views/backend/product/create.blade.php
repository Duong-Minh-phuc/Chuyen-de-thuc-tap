<x-layout-admin>
    <x-slot:title>
        Thêm mới Sản phẩm
    </x-slot>
    <div>
        <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between items-start mb-3 p-3 gap-5 rounded-md border">
                <h3 class="text-xl font-bold text-gray-900">Quản Lí Sản phẩm</h3>
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Lưu
                    </button>
                    <a href="{{ route('admin.product.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Quay lại
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-5">
                <div class="col-span-2 bg-white p-4 rounded-md shadow">
                    <div class="mb-4">
                        <label for="name" class="block text-base font-medium text-gray-600">
                            Tên sản phẩm <span class="text-red-500">*</span>
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
                        <label for="slug" class="block text-base font-medium text-gray-600">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="slug"
                            name="slug"
                            value="{{ old('slug') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('slug'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('slug') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-base font-medium text-gray-600">
                            Nội dung <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="content"
                            name="content"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">{{ old('content') }}</textarea>
                        @if ($errors->has('content'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('content') }}</div>
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
                        <label for="thumbnail" class="block text-base font-medium text-gray-600">
                            Hình ảnh <span class="text-red-500">*</span>
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
                        <label for="category_id" class="block text-base font-medium text-gray-600">
                            Danh mục <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id"
                            name="category_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="brand_id" class="block text-base font-medium text-gray-600">
                            Thương hiệu <span class="text-red-500">*</span>
                        </label>
                        <select id="brand_id"
                            name="brand_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="price_buy" class="block text-base font-medium text-gray-600">
                            Giá mua <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                            id="price_buy"
                            name="price_buy"
                            value="{{ old('price_buy', 0) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                    </div>

                    <div>
                        <label for="price_sale" class="block text-base font-medium text-gray-600">
                            Giá Sale <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                            id="price_sale"
                            name="price_sale"
                            value="{{ old('price_sale', 0) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                    </div>

                    <div>
                        <label for="qty" class="block text-base font-medium text-gray-600">
                            Số lượng <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                            id="qty"
                            name="qty"
                            value="{{ old('qty', 0) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
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
