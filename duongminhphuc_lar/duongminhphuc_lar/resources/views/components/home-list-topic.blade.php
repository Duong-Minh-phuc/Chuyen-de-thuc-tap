@foreach ($topics as $topicitem)
    <div class="productcategory py-4">
        <div class="flex items-center">
            <div class="basis-1/0">
                <a href="{{ route('site.post.topic', ['slug' => $topicitem->slug]) }}" class="text-blue-600 hover:underline text-xl">
                    <h1 class="font-bold text-1xl uppercase mb-4">{{ $topicitem->name }}</h1>
                </a>
            </div>
        </div>
    </div>
@endforeach 