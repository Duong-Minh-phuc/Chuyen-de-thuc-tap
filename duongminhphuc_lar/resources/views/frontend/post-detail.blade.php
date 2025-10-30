<x-layout-site>
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm p-8">
                <!-- Header -->
                <div class="mb-8">
                    <!-- Tiêu đề -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-3">
                        {{ $post->title }}
                    </h1>

                    <!-- Ngày đăng -->
                    <div class="flex items-center text-gray-600 text-sm">
                        <span class="font-medium mr-2">NGÀY ĐĂNG:</span>
                        <span>
                            <i class="fas fa-calendar-alt mr-2"></i>
                            {{ $post->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
                <div class="mb-8 rounded-xl overflow-hidden">
                    <div class="text-gray-800 font-medium leading-relaxed">
                        {!! $post->description !!}
                    </div>
                </div>
                <!-- Ảnh bài viết -->
                <div class="mb-8 rounded-xl overflow-hidden">
                    <img src="{{ asset('images/post/' . $post->thumbnail) }}" 
                         alt="{{ $post->title }}"
                         class="w-full h-auto object-cover hover:scale-105 transition-transform duration-500">
                </div>

                <!-- Nội dung bài viết -->
                <div class="prose max-w-none text-gray-800 leading-relaxed">
                    {!! $post->content !!}
                </div>
            </div>

            <!-- Bài viết liên quan nếu có -->
            @if(isset($related_posts) && $related_posts->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Bài viết liên quan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($related_posts as $related)
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                                <a href="{{ route('site.post.detail', ['slug' => $related->slug]) }}">
                                    <img src="{{ asset('images/post/' . $related->thumbnail) }}" 
                                         alt="{{ $related->title }}"
                                         class="w-full h-48 object-cover hover:scale-105 transition-transform duration-500">
                                </a>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-gray-600">
                                        <a href="{{ route('site.post.detail', ['slug' => $related->slug]) }}">
                                            {{ $related->title }}
                                        </a>
                                    </h3>
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        {{ $related->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout-site> 