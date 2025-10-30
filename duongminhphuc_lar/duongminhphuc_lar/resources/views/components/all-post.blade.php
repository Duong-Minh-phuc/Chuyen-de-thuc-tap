<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-center text-gray-900 mb-12">Tất cả bài viết</h1>

        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300">
                        <!-- Ảnh bài viết -->
                        <div class="relative aspect-w-16 aspect-h-9 overflow-hidden">
                            <a href="{{ route('site.post.detail', ['slug' => $post->slug]) }}">
                                <img class="object-cover w-full h-full hover:scale-110 transition-transform duration-500" 
                                     src="{{ asset('images/post/' . $post->thumbnail) }}" 
                                     alt="{{ $post->title }}">
                            </a>
                        </div>

                        <!-- Nội dung bài viết -->
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2 group">
                                <a href="{{ route('site.post.detail', ['slug' => $post->slug]) }}"
                                   class="group-hover:text-gray-600 transition-colors duration-300">
                                    {{ $post->topic->name }}
                                </a>
                            </h2>

                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ $post->description }}
                            </p>

                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    {{ $post->created_at->format('d/m/Y') }}
                                </span>
                                <a href="{{ route('site.post.detail', ['slug' => $post->slug]) }}"
                                   class="px-4 py-2 bg-gray-100 text-gray-900 rounded-lg hover:bg-gray-200 transition-colors duration-300">
                                    Đọc thêm
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center text-gray-500">
                Chưa có bài viết nào.
            </div>
        @endif
    </div>
</div> 