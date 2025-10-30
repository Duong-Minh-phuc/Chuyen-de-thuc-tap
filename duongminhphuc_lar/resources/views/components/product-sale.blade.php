<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">Sản phẩm Khuyến Mãi</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="group overflow-hidden relative">
                    <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}">
                        <img class="w-full h-[300px] object-contain group-hover:scale-105 transition-transform duration-300" 
                             src="{{ asset('images/product/' . $product->thumbnail) }}" 
                             alt="hình">
                    </a>
                </div>
                
                <div class="p-4">
                    <h2 class="text-gray-900 text-lg font-medium mb-4 text-center line-clamp-2 min-h-[3.5rem]">
                        {{ $product->name }}
                    </h2>
                    
                    <div class="flex justify-between items-center">
                        <div class="flex flex-col">
                            <span class="text-red-600 text-lg font-bold">{{ number_format($product->price_sale) }}đ</span>
                            <span class="text-gray-500 line-through text-sm">{{ number_format($product->price_buy) }}đ</span>
                        </div>
                        <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}"
                           class="text-gray-900 hover:text-gray-600 transition-colors duration-300">
                            Xem ngay
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div> 