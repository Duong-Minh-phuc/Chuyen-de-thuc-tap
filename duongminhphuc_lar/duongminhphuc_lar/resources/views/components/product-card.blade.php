<div class="productcard border bg-white">
    <div class="group overflow-hidden relative">
        <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}">
            <img class="group-hover:scale-105 w-full" src="{{ asset('images/product/' . $productitem->thumbnail) }}" alt="{{ $productitem->name }}">
            <h3>{{ $product->name }}</h3>
            <p>{{ number_format($product->price) }} đ</p>
            @if($product->price_sale > 0)
                <span class="line-through">{{ number_format($product->price_sale) }} đ</span>
            @endif
        </a>
    </div>
</div>