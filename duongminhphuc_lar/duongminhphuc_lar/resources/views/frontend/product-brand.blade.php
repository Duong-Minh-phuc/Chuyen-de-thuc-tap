<x-layout-site>
    <div class="container mx-auto px-4 py-12">
        
            <div class="w-1/4">
                <h2 class="text-3xl  font-semibold mb-4">Sản Phẩm Thương Hiệu</h2>
                
                <x-home-list-brand />
            </div>
            <div class="basis-1/0">
                <h1 class="font-bold text-2xl uppercase text-center mb-4">{{ $brand->name }}</h1>
            </div>
            <form method="GET" action="">
                <label for="sort" class="mr-2">Sắp xếp:</label>
                
                <input type="hidden" name="view" value="{{ request('view', 'grid') }}">
                <select name="sort" id="sort" class="border border-gray-300 rounded-md p-2" onchange="this.form.submit()">
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="price_buy" {{ request('sort') == 'price_buy' ? 'selected' : '' }}>Giá thấp nhất</option>
                    <option value="price_buy_desc" {{ request('sort') == 'price_buy_desc' ? 'selected' : '' }}>Giá cao nhất</option>
                </select>
            </form>
            
            <div class="flex justify-end mb-4">
                <a href="?view=grid&sort={{ request('sort', 'created_at') }}" 
                   class="px-4 py-2 rounded-md {{ request('view', 'grid') == 'grid' ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-800' }}">
                    Lưới
                </a>
                <a href="?view=list&sort={{ request('sort', 'created_at') }}" 
                   class="ml-2 px-4 py-2 rounded-md {{ request('view') == 'list' ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-800' }}">
                    Danh sách
                </a>
            </div>
            
        
            <!-- Sản phẩm -->
            @if(request('view', 'grid') == 'grid')
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
                                <h2 class="text-gray-900 text-lg font-medium text-center mb-3">
                                    {{ $product->name }}
                                </h2>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-900 font-semibold">Giá: {{ number_format($product->price_buy) }} VNĐ</span>
                                    <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}"
                                       class="text-gray-900 hover:text-gray-600 transition-colors duration-300">
                                        Chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="space-y-4">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 flex items-center">
                            <div class="w-1/4">
                                <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}">
                                    <img class="w-full h-[300px] object-contain group-hover:scale-105 transition-transform duration-300" 
                                    src="{{ asset('images/product/' . $product->thumbnail) }}" 
                                    alt="hình">
                                </a>
                            </div>
                            
                            <div class="w-3/4 p-4">
                                <h2 class="text-gray-900 text-lg font-medium mb-3">
                                    {{ $product->name }}
                                </h2>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-900 font-semibold">Giá: {{ number_format($product->price_buy) }} VNĐ</span>
                                    <a href="{{ route('site.product.detail', ['slug' => $product->slug]) }}"
                                       class="text-gray-900 hover:text-gray-600 transition-colors duration-300">
                                        Chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        
            <!-- Phân trang -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>
            
 
</x-layout-site>
