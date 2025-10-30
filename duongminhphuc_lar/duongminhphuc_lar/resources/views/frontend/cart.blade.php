<x-layout-site>
    <section class="bg-gray-100 py-8">
        <div class="container mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="flex space-x-2 py-2 my-0">
                    <li class="breadcrumb-item">
                        <a class="text-blue-600 hover:underline" href="/">Trang chủ /</a>
                    </li>
                    <li class="breadcrumb-item text-gray-500" aria-current="page">
                        Giỏ hàng của bạn
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-lg shadow-md">
                <form action="{{ route('site.updatecart') }}" method="POST">
                    @csrf
                    <table class="min-w-full">
                        <thead class="bg-black text-white">
                            <tr>
                                <th class="py-2 px-4">Hình</th>
                                <th class="py-2 px-4">Tên sản phẩm</th>
                                <th class="py-2 px-4 text-center">Giá</th>
                                <th class="py-2 px-4 text-center">Số lượng</th>
                                <th class="py-2 px-4 text-center">Thành tiền</th>
                                <th class="py-2 px-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $id => $product)
                            <tr class="border-b">
                                <td class="py-2 px-4">
                                    <img src="{{ asset('images/product/' . $product['thumbnail']) }}" alt="{{ $product['name'] }}" class="w-24 h-24 object-cover">
                                </td>
                                <td class="py-2 px-4">{{ $product['name'] }}</td>
                                <td class="py-2 px-4 text-center">{{ number_format($product['price']) }} đ</td>
                                <td class="py-2 px-4 text-center">
                                    <input type="number" name="qty[{{ $id }}]" value="{{ $product['qty'] }}" class="w-16 text-center border border-gray-300 rounded mx-2" min="1" />
                                </td>
                                <td class="py-2 px-4 text-center">{{ number_format($product['price'] * $product['qty']) }} đ</td>
                                <td class="py-2 px-4 text-center">
                                    <a href="{{ route('site.delcart', ['id' => $id]) }}" class="bg-red-500 text-white px-2 py-1 rounded">Xóa</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-center py-2 px-4">
                                    <div class="flex justify-center space-x-4">
                                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cập nhật</button>
                                        <a href="{{ route('site.checkout.cart') }}" class="bg-red-500 text-white px-4 py-2 rounded">Thanh Toán</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right py-2 px-4">
                                    <h4 class="text-lg font-bold">Tổng tiền: {{ number_format(array_sum(array_map(function($item) {
                                        return $item['price'] * $item['qty'];
                                    }, $cart))) }} đ</h4>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
    </section>
</x-layout-site>
