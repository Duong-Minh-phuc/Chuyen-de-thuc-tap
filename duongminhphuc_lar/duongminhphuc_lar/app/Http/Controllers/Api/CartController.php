<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu giỏ hàng thành công',
            'data' => $cart
        ]);
    }

    public function addcart(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Sản phẩm không tồn tại',
                'data' => null
            ]);
        }

        $cart = session()->get('cart', []);
        $qty = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
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

    public function updatecart(Request $request)
    {
        $cart = session()->get('cart', []);
        $qty = $request->input('qty', []);

        foreach ($qty as $id => $n) {
            if (isset($cart[$id])) {
                $cart[$id]['qty'] = (int)$n;
            }
        }

        session()->put('cart', $cart);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật giỏ hàng thành công',
            'data' => $cart
        ]);
    }

    public function delcart($id = null)
    {
        $cart = session()->get('cart', []);
        
        if ($id !== null && array_key_exists($id, $cart)) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return response()->json([
                'status' => true,
                'message' => 'Xóa sản phẩm thành công',
                'data' => $cart
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng',
            'data' => null
        ]);
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn cần đăng nhập để thanh toán',
                'data' => null
            ]);
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json([
                'status' => false,
                'message' => 'Giỏ hàng trống',
                'data' => null
            ]);
        }

        $order = new Order();
        $order->user_id = $user->id;
        $order->name = $request->input('delivery_name');
        $order->email = $request->input('delivery_email');
        $order->phone = $request->input('delivery_phone');
        $order->address = $request->input('delivery_address');
        $order->created_by = $user->id;
        $order->created_at = now();
        $order->status = 1;

        if ($order->save()) {
            $orderDetails = [];
            foreach ($cart as $id => $item) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $id;
                $orderDetail->qty = $item['qty'];
                $orderDetail->price = $item['price'];
                $orderDetail->discount = 0;
                $orderDetail->amount = $item['qty'] * $item['price'];
                $orderDetail->save();
                $orderDetails[] = $orderDetail;
            }

            session()->forget('cart');
            return response()->json([
                'status' => true,
                'message' => 'Đặt hàng thành công',
                'data' => [
                    'order' => $order,
                    'order_details' => $orderDetails
                ]
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Đặt hàng thất bại',
            'data' => null
        ]);
    }
} 