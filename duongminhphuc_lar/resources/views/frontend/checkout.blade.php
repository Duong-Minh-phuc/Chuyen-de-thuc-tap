<x-layout-site>
    <section class="bg-gray-100 py-8">
        <div class="container mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="flex space-x-2 py-2 my-0">
                    <li class="breadcrumb-item">
                        <a class="text-blue-600 hover:underline" href="/">Trang chủ /</a>
                    </li>
                    <li class="breadcrumb-item text-gray-500" aria-current="page">
                        Thanh toán
                    </li>
                </ol>
            </nav>

            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/2 px-4">
                    <form action="{{ route('site.checkout') }}" method="POST">
                        @csrf
                        <h2 class="text-lg font-bold mb-4 text-center">Thông tin giao hàng</h2>

                        <div class="mb-4 ml-3">
                            <label for="delivery_name" class="block text-sm font-medium text-gray-700">Họ tên</label>
                            <input type="text" id="delivery_name" name="delivery_name" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Nhập họ tên" required>
                        </div>

                        <div class="mb-4 ml-3">
                            <label for="delivery_phone" class="block text-sm font-medium text-gray-700">Điện thoại</label>
                            <input type="tel" id="delivery_phone" name="delivery_phone" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Nhập điện thoại" required>
                        </div>

                        <div class="mb-4 ml-3">
                            <label for="delivery_email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="delivery_email" name="delivery_email" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Nhập email" required>
                        </div>

                        <div class="mb-4 ml-3">
                            <label for="delivery_address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                            <input type="text" id="delivery_address" name="delivery_address" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Nhập địa chỉ" required>
                        </div>

                        <h4 class="text-md font-bold mt-4 ml-3">Ghi chú về sản phẩm</h4>
                        <div class="mb-4 ml-7">
                            @if(isset($product))
                                <div class="form-control mb-2">
                                    {{ $product->name }}: {{ $quantity }}
                                </div>
                            @else
                                @foreach($cart as $item)
                                    <div class="form-control mb-2">
                                        {{ $item['name'] }}: {{ $item['qty'] }}
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <h4 class="text-md font-bold mt-4 ml-3">Phương thức thanh toán</h4>
                        <div class="p-4 border border-gray-300 rounded-md mb-4">
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="cod" class="mr-2" checked>
                                Thanh toán khi giao hàng
                            </label>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">XÁC NHẬN</button>
                        </div>
                    </form>
                </div>

                <div class="w-full md:w-1/2 px-4">
                    <h2 class="text-lg font-bold mb-4">Thông tin đơn hàng</h2>
                    @if(isset($product))
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="py-2 px-4 text-left">STT</th>
                                    <th class="py-2 px-4">Tên sản phẩm</th>
                                    <th class="py-2 px-4 text-center">Giá</th>
                                    <th class="py-2 px-4 text-center">Số lượng</th>
                                    <th class="py-2 px-4 text-center">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 text-left">1</td>
                                    <td class="py-2 px-4">{{ $product->name }}</td>
                                    <td class="py-2 px-4 text-center">{{ number_format($product->price_sale > 0 ? $product->price_sale : $product->price_buy) }} đ</td>
                                    <td class="py-2 px-4 text-center">{{ $quantity }}</td>
                                    <td class="py-2 px-4 text-center">{{ number_format(($product->price_sale > 0 ? $product->price_sale : $product->price_buy) * $quantity) }} đ</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        @if(count($cart) > 0)
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="py-2 px-4 text-left">STT</th>
                                        <th class="py-2 px-4">Tên sản phẩm</th>
                                        <th class="py-2 px-4 text-center">Giá</th>
                                        <th class="py-2 px-4 text-center">Số lượng</th>
                                        <th class="py-2 px-4 text-center">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $index => $item)
                                        <tr>
                                            <td class="py-2 px-4 text-left">{{ $index + 1 }}</td>
                                            <td class="py-2 px-4">{{ $item['name'] }}</td>
                                            <td class="py-2 px-4 text-center">{{ number_format($item['price']) }} đ</td>
                                            <td class="py-2 px-4 text-center">{{ $item['qty'] }}</td>
                                            <td class="py-2 px-4 text-center">{{ number_format($item['price'] * $item['qty']) }} đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Không có sản phẩm để thanh toán.</p>
                        @endif
                    @endif

                    <div class="mt-4">
                        <h4 class="text-md font-bold">Tổng tiền:</h4>
                        <p>{{ number_format(isset($product) ? ($product->price_sale > 0 ? $product->price_sale : $product->price_buy) * $quantity : array_sum(array_map(function($item) {
                            return $item['price'] * $item['qty'];
                        }, $cart))) }} đ</p>
                        <h4 class="text-md font-bold">Phí vận chuyển:</h4>
                        <p>{{ number_format(30) }} đ</p>
                        <h4 class="text-md font-bold">Tổng cộng:</h4>
                        <p>{{ number_format((isset($product) ? ($product->price_sale > 0 ? $product->price_sale : $product->price_buy) * $quantity : array_sum(array_map(function($item) {
                            return $item['price'] * $item['qty'];
                        }, $cart))) + 30) }} đ</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout-site>