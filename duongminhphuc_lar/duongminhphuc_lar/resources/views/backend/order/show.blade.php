<x-layout-admin>
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Chi tiết Đơn hàng #{{ $orders->id }}</h2>
                <div class="space-x-2">
                    @if(in_array($orders->status, [5, 7]))
                    <a href="{{ route('admin.order.delete', ['order' => $orders->id]) }}"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 inline-flex items-center transition duration-200">
                        <i class="fa-solid fa-trash mr-2"></i>
                        Xóa
                    </a>
                    @endif
                    <a href="{{ route('admin.order.index') }}"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 inline-flex items-center transition duration-200">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Về danh sách
                    </a>
                </div>
            </div>

            <!-- Thông tin khách hàng -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Thông tin khách hàng</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="text-gray-600 w-32">Họ tên:</span>
                            <span class="font-medium">{{ $orders->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 w-32">Email:</span>
                            <span class="font-medium">{{ $orders->email }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 w-32">Số điện thoại:</span>
                            <span class="font-medium">{{ $orders->phone }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 w-32">Địa chỉ:</span>
                            <span class="font-medium">{{ $orders->address }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Thông tin đơn hàng</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="text-gray-600 w-32">Mã đơn hàng:</span>
                            <span class="font-medium">#{{ $orders->id }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 w-32">Ngày đặt:</span>
                            <span class="font-medium">{{ date('d/m/Y H:i', strtotime($orders->created_at)) }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 w-32">Trạng thái:</span>
                            @if($orders->status != 5)
                            <select onchange="updateOrderStatus(this, '{{ $orders->id }}')"
                                class="rounded-full px-3 py-1 text-sm font-medium
                                @if($orders->status == 1) bg-yellow-100 text-yellow-800
                                @elseif($orders->status == 2) bg-blue-100 text-blue-800
                                @elseif($orders->status == 4) bg-indigo-100 text-indigo-800
                                @elseif($orders->status == 5) bg-green-100 text-green-800
                                @elseif($orders->status == 7) bg-red-100 text-red-800
                                @endif">
                                <option value="1" {{ $orders->status == 1 ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="2" {{ $orders->status == 2 ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="4" {{ $orders->status == 4 ? 'selected' : '' }}>Đang giao hàng</option>
                                <option value="5" {{ $orders->status == 5 ? 'selected' : '' }}>Đã giao hàng</option>
                                <option value="7" {{ $orders->status == 7 ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                            @else
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Đã giao hàng
                            </span>
                            @endif
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 w-32">Ghi chú:</span>
                            <span class="font-medium">{{ $orders->note ?? 'Không có' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chi tiết sản phẩm -->
            <div class="bg-white rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 p-4 border-b">Chi tiết sản phẩm</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giảm giá</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orderdetails as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <img class="h-12 w-12 rounded-lg object-cover"
                                                src="{{ asset('images/product/'.$item->thumbnail) }}"
                                                alt="{{ $item->product_name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($item->price) }}đ</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $item->qty }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($item->discount > 0)
                                            <span class="text-red-600 font-medium">{{ number_format($item->discount) }}đ</span>
                                        @else
                                            <span class="text-gray-500">Không giảm giá</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ number_format($item->amount) }}đ</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-right font-medium text-gray-500">Tổng tiền:</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-lg font-bold text-blue-600">
                                        {{ number_format($orderdetails->sum('amount')) }}đ
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript for updating order status --}}
    <script>
    function updateOrderStatus(select, orderId) {
        if (confirm('Bạn có chắc chắn muốn thay đổi trạng thái đơn hàng này?')) {
            let url = "{{ route('admin.order.update-status', ['order' => ':orderId']) }}";
            url = url.replace(':orderId', orderId);
            window.location.href = url + "?status=" + select.value;
        } else {
            // Reset to previous value if user cancels
            select.value = select.getAttribute('data-previous');
        }
    }

    // Store previous values when dropdown is opened
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('focus', function() {
            this.setAttribute('data-previous', this.value);
        });
    });
    </script>
</x-layout-admin>
