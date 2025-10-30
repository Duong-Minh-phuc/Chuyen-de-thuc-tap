<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $user = session()->get('user_site', []);

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!$user) {
            return redirect()->route('site.login')->with('error', 'Bạn cần đăng nhập để thanh toán.');
        }

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);
        
        // Kiểm tra xem có sản phẩm từ trang chi tiết không
        if ($id) {
            $product = Product::find($id);
            
            // Kiểm tra xem sản phẩm có tồn tại không
            if (!$product) {
                return redirect()->route('site.home')->with('error', 'Sản phẩm không tồn tại.');
            }

            // Lấy số lượng từ request
            $quantity = $request->input('quantity', 1);

            // Tính tổng tiền
            $total = $quantity * ($product->price_sale > 0 ? $product->price_sale : $product->price_buy);
        } else {
            // Nếu không có sản phẩm từ trang chi tiết, sử dụng giỏ hàng
            if (empty($cart)) {
                return redirect()->route('site.cart')->with('error', 'Giỏ hàng của bạn trống.');
            }

            // Tính tổng tiền từ giỏ hàng
            $total = array_sum(array_map(function($item) {
                return $item['price'] * $item['qty'];
            }, $cart));
        }

        // Cộng thêm phí vận chuyển
        $shippingFee = 30; // Phí vận chuyển
        $total += $shippingFee;

        // Truyền dữ liệu đến view thanh toán
        return view('frontend.checkout', compact('product', 'quantity', 'cart', 'total'));
    }
} 