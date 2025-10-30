<x-layout-admin>
    <div class="bg-white rounded-lg shadow-md">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <div class="p-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Quản lý Đơn Hàng</h2>
                <div class="space-x-2">
                    <a href="{{ route('admin.order.trash') }}" class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600 inline-flex items-center">
                        <i class="fa-solid fa-trash mr-2"></i>
                        Thùng rác
                    </a>
                </div>
            </div>

            <!-- Thanh trạng thái đơn hàng -->
            <div class="flex space-x-2 mt-4 overflow-x-auto pb-2">
                <a href="{{ route('admin.order.index') }}"
                    class="px-4 py-2 rounded-full {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }} hover:opacity-90">
                    Tất cả
                </a>
                <a href="{{ route('admin.order.index', ['status' => 1]) }}"
                    class="px-4 py-2 rounded-full {{ request('status') == 1 ? 'bg-yellow-600 text-white' : 'bg-gray-200 text-gray-700' }} hover:opacity-90">
                    Đang xử lý
                </a>
                <a href="{{ route('admin.order.index', ['status' => 2]) }}"
                    class="px-4 py-2 rounded-full {{ request('status') == 2 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }} hover:opacity-90">
                    Đã xác nhận
                </a>
                <a href="{{ route('admin.order.index', ['status' => 4]) }}"
                    class="px-4 py-2 rounded-full {{ request('status') == 4 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }} hover:opacity-90">
                    Đang giao hàng
                </a>
                <a href="{{ route('admin.order.index', ['status' => 5]) }}"
                    class="px-4 py-2 rounded-full {{ request('status') == 5 ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }} hover:opacity-90">
                    Đã giao hàng
                </a>
                <a href="{{ route('admin.order.index', ['status' => 7]) }}"
                    class="px-4 py-2 rounded-full {{ request('status') == 7 ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700' }} hover:opacity-90">
                    Đã hủy
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="p-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-12 px-4 py-3 text-center">#</th>
                        <th class="px-4 py-3 text-left">Mã ĐH</th>
                        <th class="px-4 py-3 text-left">Tên Khách Hàng</th>
                        <th class="px-4 py-3 text-left">Phone</th>
                        <th class="px-4 py-3 text-left">Tổng tiền</th>
                        <th class="px-4 py-3 text-left">Trạng thái</th>
                        <th class="px-4 py-3 text-left">Ngày đặt</th>
                        <th class="w-48 px-4 py-3 text-center">Chức năng</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" class="rounded border-gray-300">
                        </td>
                        <td class="px-4 py-3">#{{ $order->id }}</td>
                        <td class="px-4 py-3">{{ $order->name }}</td>
                        <td class="px-4 py-3">{{ $order->phone }}</td>
                        <td class="px-4 py-3">{{ number_format($order->orderDetails->sum('amount')) }}đ</td>
                        <td class="px-4 py-3">
                            @if($order->status != 5)
                            <select onchange="updateOrderStatus(this, '{{ $order->id }}')"
                                class="rounded-full px-3 py-1 text-sm font-medium
                                @if($order->status == 1) bg-yellow-100 text-yellow-800
                                @elseif($order->status == 2) bg-blue-100 text-blue-800
                                @elseif($order->status == 4) bg-indigo-100 text-indigo-800
                                @elseif($order->status == 5) bg-green-100 text-green-800
                                @elseif($order->status == 7) bg-red-100 text-red-800
                                @endif">
                                <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Đang giao hàng</option>
                                <option value="5" {{ $order->status == 5 ? 'selected' : '' }}>Đã giao hàng</option>
                                <option value="7" {{ $order->status == 7 ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                            @else
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Đã giao hàng
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-center space-x-2">
                            {{-- Show button --}}
                            <a href="{{ route('admin.order.show', ['order' => $order->id]) }}"
                                class="inline-flex p-1 bg-green-600 text-white rounded hover:opacity-75">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            {{-- Delete button --}}
                            @if(in_array($order->status, [5, 7]))
                            <a href="{{ route('admin.order.delete', ['order' => $order->id]) }}"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')"
                                class="inline-flex p-1 bg-red-600 text-white rounded hover:opacity-75">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4 border-t border-gray-200">
            {{ $orders->links() }}
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
