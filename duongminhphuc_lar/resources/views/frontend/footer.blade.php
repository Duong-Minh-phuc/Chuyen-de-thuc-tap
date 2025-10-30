<footer class="bg-white shadow-sm mt-8">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Về chúng tôi -->
            <div>
                <h3 class="text-gray-800 font-semibold text-lg mb-4">VỀ CHÚNG TÔI</h3>
                <p class="text-gray-600 mb-2">Bản quyền thuộc về Blanc Perfume</p>
                <div class="mb-2">
                    <p class="text-gray-600 cursor-pointer hover:text-gray-900">
                        🏠 <span class="underline">
                            91/17a - Đường số 8, Linh trung Thủ đức, TPHCM
                        </span>
                    </p>

                    <!-- Map container -->
                    <div id="mapContainer" class="hidden mt-4">
                        <iframe
                            class="w-full h-[450px] border-0"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.5874491446866!2d106.76986231474956!3d10.85026239227386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317527b1f5eb25e9%3A0x2c2b1e3a9a4b40ba!2zOTEvMTdhIMSQLiDEkMO0bmcgU-G7syA4LCBMaW5oIFRydW5nLCBUaOG7pyDEkOG7qWMsIFRo4buLIMSQ4buRbmcgVGjhu6cgQ2jDrSBNaW5oLCBUaOG7pyDEkOG7qWMsIFZpZXRuYW0!5e0!3m2!1sen!2sus!4v1591346245175!5m2!1sen!2sus"
                            allowfullscreen=""
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
                <a href="mailto:nguyentruong2792004t@Blanc-perfume.vn"
                   class="text-gray-600 hover:text-gray-900 block mb-2">
                    📧 minhphuc@Blanc-perfume.vn
                </a>
                <p class="text-gray-600">📞 0362.97577.62</p>
            </div>

            <!-- Liên kết -->
            <div>
                <h3 class="text-gray-800 font-semibold text-lg mb-4">LIÊN KẾT</h3>
               <x-footer-menu />
            </div>

            <!-- FooterMenu -->
            <div>
                {{-- @TODO: Thêm FooterMenu component sau --}}
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <p class="text-center text-gray-600">
                Copyright © 2024 BLANC PERFUME - 2122110594:Dương Minh Phúc
            </p>
        </div>
    </div>
</footer>

