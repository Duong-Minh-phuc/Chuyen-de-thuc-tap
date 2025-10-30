<x-layout-admin>
    <x-slot:title>
        Chỉnh sửa Bài viết
    </x-slot>
    <div>
        <form action="{{ route('admin.post.update', ['post' => $post->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex justify-between items-start mb-3 p-3 gap-5 rounded-md border">
                <h3 class="text-xl font-bold text-gray-900">Chỉnh sửa Bài viết</h3>
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Lưu
                    </button>
                    <a href="{{ route('admin.post.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Quay lại
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-5">
                <div class="col-span-2 bg-white p-4 rounded-md shadow">
                    <div class="mb-4">
                        <label for="title" class="block text-base font-medium text-gray-600">
                            Tiêu đề <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="title"
                            name="title"
                            value="{{ old('title', $post->title) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('title'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('title') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="slug" class="block text-base font-medium text-gray-600">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            id="slug"
                            name="slug"
                            value="{{ old('slug', $post->slug) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                        @if ($errors->has('slug'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('slug') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-base font-medium text-gray-600">
                            Mô tả <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="description"
                            name="description"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">{{ old('description', $post->description) }}</textarea>
                        @if ($errors->has('description'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('description') }}</div>
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
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">{{ old('content', $post->content) }}</textarea>
                        @if ($errors->has('content'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('content') }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="thumbnail" class="block text-base font-medium text-gray-600">
                            Hình ảnh <span class="text-red-500">*</span>
                        </label>
                        <input type="file" 
                            id="thumbnail"
                            name="thumbnail"
                            class="mt-1 block w-full">
                        @if ($errors->has('thumbnail'))
                            <div class="text-red-500 text-sm mt-1">{{ $errors->first('thumbnail') }}</div>
                        @endif
                        @if($post->thumbnail)
                            <div class="mt-2">
                                <img src="{{ asset('images/post/'.$post->thumbnail) }}" alt="Current Image" class="w-32 h-32 object-cover">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-span-1 bg-white p-4 rounded-md shadow">
                    <div class="mb-4">
                        <label for="topic_id" class="block text-base font-medium text-gray-600">
                            Chủ đề <span class="text-red-500">*</span>
                        </label>
                        <select id="topic_id"
                            name="topic_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}" {{ $post->topic_id == $topic->id ? 'selected' : '' }}>
                                    {{ $topic->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-base font-medium text-gray-600">
                            Loại bài viết <span class="text-red-500">*</span>
                        </label>
                        <select id="type"
                            name="type"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-base">
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ $post->type == $type ? 'selected' : '' }}>
                                    {{ $type }}
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
                            <option value="2" {{ $post->status == 2 ? 'selected' : '' }}>Chưa xuất bản</option>
                            <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Xuất bản</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layout-admin>
