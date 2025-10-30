<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">Tin Tức Mới</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="group overflow-hidden relative">
                    <a href="{{ route('site.post.detail', ['slug' => $post->slug]) }}">
                        <img class="w-full h-[200px] object-cover group-hover:scale-105 transition-transform duration-300" 
                             src="{{ asset('images/post/' . $post->thumbnail) }}" 
                             alt="{{ $post->title }}">
                    </a>
                </div>
                
                <div class="p-4">
                    <h3 class="text-gray-900 text-lg font-medium mb-2 line-clamp-2 min-h-[3.5rem]">
                        {{ $post->title }}
                    </h3>
                    
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {{ $post->description }}
                    </p>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-sm">
                            {{ $post->created_at->format('d/m/Y') }}
                        </span>
                        <a href="{{ route('site.post.detail', ['slug' => $post->slug]) }}"
                           class="text-blue-600 hover:text-blue-700 text-sm font-medium transition-colors duration-300">
                            Xem thêm
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $posts->links() }}
</div> 