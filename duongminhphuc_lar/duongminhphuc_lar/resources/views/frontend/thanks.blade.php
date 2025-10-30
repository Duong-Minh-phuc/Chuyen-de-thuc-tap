<x-layout-site>
    <section class="bg-gray-100 py-8">
        <div class="container mx-auto">
            <h2 class="text-lg font-bold mb-4 text-center">Cảm ơn bạn đã đặt hàng!</h2>
            <p class="text-center">Đơn hàng của bạn đã được ghi nhận thành công.</p>
            <p class="text-center">Chúng tôi sẽ liên hệ với bạn sớm nhất có thể để xác nhận đơn hàng.</p>
            <div class="text-center mt-10">
                <!-- Di chuyển nút xuống dưới -->
                <a href="{{ route('site.home') }}" class="bg-blue-500 mt-5 text-white px-4 py-2 rounded">Quay lại trang chủ</a>
            </div>
        </div>
    </section>
</x-layout-site>