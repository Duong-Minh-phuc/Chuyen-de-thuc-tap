<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;

class CarController extends Controller
{
    function index()
    {
        $cart= session()->get('cart', []);
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $cart
        ]);
    }
    public function addcart(Request $request, $id)
    {
        $product = Product::find($id);
        $cart = session()->get('cart', []);
        
        // Lấy số lượng từ request
        $qty = $request->input('quantity', 1); // Mặc định là 1 nếu không có

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty; // Tăng số lượng
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price_buy,
                'qty' => $qty,
                'thumbnail' => $product->thumbnail,
            ];
        }

        session()->put('cart', $cart);
        return response()->json([
            'status' => true,
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
            'data' => $cart
        ]);
    }
   
function updatecart(Request $request)
{
    $cart = session()->get('cart', []);
    $qty = $request->input('qty', []);

    foreach ($qty as $id => $n) {
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $n; // Cập nhật số lượng
        }
    }

    session()->put('cart', $cart);
    return response()->json([
        'status' => true,
        'message' => 'Cập nhật giỏ hàng thành công',
        'data' => $cart
    ]);
}
function delcart($id = null)
{
    $cart = session()->get('cart', []);
    
    if ($id !== null && array_key_exists($id, $cart)) {
        unset($cart[$id]); // Xóa sản phẩm khỏi giỏ hàng
        session()->put('cart', $cart);
    }

    return response()->json([
        'status' => true,
        'message' => 'Xóa sản phẩm thành công',
        'data' => $cart
    ]);
}

    public function checkout(Request $request)
    {
        // Lấy thông tin người dùng từ session
        $user = session()->get('user_site', []);
        
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!$user) {
            return redirect()->route('site.login')->with('error', 'Bạn cần đăng nhập để thanh toán.');
        }

        $cart = session()->get('cart', []);

        $order = new Order();
        $order->user_id = $user['id']; // Gán user_id từ session
        $order->name = $request->input('delivery_name');
        $order->email = $request->input('delivery_email');
        $order->phone = $request->input('delivery_phone');
        $order->address = $request->input('delivery_address');
        $order->created_by = $user['id'];
        $order->created_at = now();
        $order->status = 1;

        if ($order->save()) {
            foreach ($cart as $id => $item) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $id;
                $orderDetail->qty = $item['qty'];
                $orderDetail->price = $item['price'];
                $orderDetail->discount = 0;
                $orderDetail->amount = $item['qty'] * $item['price'] - $orderDetail->discount;
                $orderDetail->save();
            }

            session()->forget('cart');
        }

        return redirect()->route('site.thanks')->with('success', 'Đặt hàng thành công');
    }

    public function showCheckoutPage()
    {
        // Lấy thông tin người dùng từ session
        $user = session()->get('user_site', []);

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!$user) {
            return redirect()->route('site.login')->with('error', 'Bạn cần đăng nhập để thanh toán.');
        }

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // Tính tổng tiền
        $total = array_sum(array_map(function($item) {
            return $item['price'] * $item['qty'];
        }, $cart));

        // Cộng thêm phí vận chuyển
        $shippingFee = 30; // Phí vận chuyển
        $total += $shippingFee;

        // Truyền dữ liệu đến view thanh toán
        return view('frontend.checkout', compact('cart', 'total'));
    }

    public function thanks()
    {
        return view('frontend.thanks');
    }
} 