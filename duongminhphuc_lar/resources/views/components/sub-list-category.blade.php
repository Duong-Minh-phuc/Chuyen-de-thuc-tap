@if ($category_list != null)
    <ul class="list-disc">
        @foreach ($category_list as $item)
            <li>
                <a href="{{ route('site.product.category', ['slug' => $item->slug]) }}" class="text-gray-800 font-bold text-2xl">
                    {{ $item->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endif 