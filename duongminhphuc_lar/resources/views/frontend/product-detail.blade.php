<x-layout-site>
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-7xl mx-auto">
            <!-- Chi tiết sản phẩm -->
            <div class="bg-white rounded-xl shadow-sm p-8 mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Ảnh sản phẩm -->
                    <div class="overflow-hidden rounded-xl">
                        <img src="{{ asset('images/product/' . $product->thumbnail) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-[500px] object-contain hover:scale-105 transition-transform duration-500">
                    </div>

                    <!-- Thông tin sản phẩm -->
                    <div class="space-y-6">
                        <h1 class="text-3xl font-bold text-gray-900">
                            {{ $product->name }}
                        </h1>

                        <!-- Danh mục -->
                        <div class="flex items-center text-gray-600 text-sm">
                            <span class="font-medium mr-2">DANH MỤC:</span>
                            <span>{{ $product->category->name }}</span>
                        </div>

                        <!-- Giá -->
                        <div class="flex items-center text-gray-600 text-sm">
                            <span class="font-medium mr-2">GIÁ:</span>
                            @if($product->price_sale > 0)
                                <div class="flex items-center space-x-4">
                                    <span class="text-2xl font-bold text-red-600">
                                        {{ number_format($product->price_sale) }}đ
                                    </span>
                                    <span class="text-lg text-gray-500 line-through">
                                        {{ number_format($product->price_buy) }}đ
                                    </span>
                                </div>
                            @else
                                <span class="text-2xl font-bold text-gray-900">
                                    {{ number_format($product->price_buy) }}đ
                                </span>
                            @endif
                        </div>

                        <!-- Mô tả ngắn -->
                        <div class="text-gray-800 font-medium">
                            {!! $product->description !!}
                            <!-- {!! nl2br(e(strip_tags(html_entity_decode($product->description)))) !!} -->


                        </div>

                        <!-- Form mua hàng -->
                        <div class="space-y-4 pt-6 border-t border-gray-200">
                            <!-- Số lượng -->
                            <form action="{{ route('site.addcart', ['id' => $product->id]) }}" method="POST">
                                @csrf
                                <div class="flex items-center space-x-4">
                                    <label class="text-gray-700 font-medium">Số lượng:</label>
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button"
                                                class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-gray-700 hover:bg-gray-100 rounded-l-lg"
                                                onclick="decreaseQuantity()">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number"
                                               id="quantity"
                                               name="quantity"
                                               value="1"
                                               min="1"
                                               class="w-16 h-10 text-center border-x border-gray-300 focus:outline-none">
                                        <button type="button"
                                                class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-gray-700 hover:bg-gray-100 rounded-r-lg"
                                                onclick="increaseQuantity()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Nút mua hàng -->
                                <div class="flex items-center space-x-4 mt-5">
                                    <button type="submit"
                                            class="flex-1 bg-gray-900 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-800 transition-colors duration-300 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-shopping-cart text-2xl mb-1"></i>
                                            <span>Thêm vào giỏ hàng</span>
                                        </div>
                                    </button>
                                    <a href="{{ route('site.checkout.detail', ['id' => $product->id]) }}"
                                       class="flex-1 bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition-colors duration-300 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-bolt text-2xl mb-1"></i>
                                            <span>Mua ngay</span>
                                        </div>
                                    </a>
                                </div>
                            </form>
                        </div>

                        <!-- Chi tiết -->
                        <div class="prose max-w-none text-gray-700 pt-6 border-t border-gray-200">
                            {!! $product->detail !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm liên quan -->
            @if(isset($related_products) && $related_products->count() > 0)
                <div class="bg-white rounded-xl shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Sản phẩm liên quan</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($related_products as $related)
                            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                                <div class="group overflow-hidden relative">
                                    <a href="{{ route('site.product.detail', ['slug' => $related->slug]) }}">
                                        <img class="w-full h-[300px] object-contain group-hover:scale-105 transition-transform duration-300"
                                             src="{{ asset('images/product/' . $related->thumbnail) }}"
                                             alt="{{ $related->name }}">
                                    </a>
                                </div>

                                <div class="p-4">
                                    <h3 class="text-gray-900 text-lg font-medium text-center mb-3 line-clamp-2">
                                        {{ $related->name }}
                                    </h3>

                                    <div class="flex justify-between items-center">
                                        @if($related->price_sale > 0)
                                            <span class="text-red-600 font-semibold">
                                                {{ number_format($related->price_sale) }}đ
                                            </span>
                                            <span class="text-gray-500 line-through text-sm">
                                                {{ number_format($related->price) }}đ
                                            </span>
                                        @else
                                            <span class="text-gray-900 font-semibold">
                                                {{ number_format($related->price) }}đ
                                            </span>
                                        @endif
                                        <a href="{{ route('site.product.detail', ['slug' => $related->slug]) }}"
                                           class="text-gray-900 hover:text-gray-600 transition-colors duration-300">
                                           Xem ngay
                                        </a>
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

<script>
    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
    }

    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        if (quantityInput.value > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    }
</script>
