<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')
            ->select("id", "user_id", "name", "email", "phone", "address", "status")
            ->with(['user'])
            ->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Tạo order mới
            $order = new Order();
            $order->user_id =$request->user_id;
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->note = $request->note;
            $order->created_by = 1;
            $order->status = 1; // Đơn hàng mới

            if (!$order->save()) {
                throw new \Exception("Không thể tạo đơn hàng");
            }

            // Tạo order details từ giỏ hàng
            $cart_items = $request->cart_items; // Mảng các sản phẩm từ giỏ hàng
            foreach ($cart_items as $item) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $item['product_id'];
                $orderDetail->qty = $item['qty'];
                $orderDetail->price = $item['price'];
                $orderDetail->amount = $item['price'] * $item['qty'];
                $orderDetail->discount = $item['discount'] ?? 0;

                if (!$orderDetail->save()) {
                    throw new \Exception("Không thể tạo chi tiết đơn hàng");
                }
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Đặt hàng thành công',
                'data' => [
                    'order' => $order,
                    'order_details' => $cart_items
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $orders = Order::join('users', 'order.user_id', '=', 'users.id')
        ->where('order.id', $id)
        ->select('order.*', 'users.fullname', 'order.status as status_label')
        ->first();

    if (!$orders) {
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy dữ liệu',
            'data' => null
        ]);
    }

    // Lấy chi tiết đơn hàng
    $orderdetails = OrderDetail::join('products', 'orderdetail.product_id', '=', 'products.id')
        ->where('orderdetail.order_id', $id)
        ->select(
            'orderdetail.*',
            'products.name as product_name',
            'products.thumbnail',
            'products.price_buy',
            'products.price_sale'
        )
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => [
                'order' => $orders,
                'order_details' => $orderdetails
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        return view('backend.order.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->join('users', 'order.user_id', '=', 'users.id')
        ->where('order.id', $id)
        ->select('order.*', 'users.fullname')
        ->first();
        
        if ($order == null) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy dữ liệu',
                'order' => null
            ]);
        }
        $order->note = $request->note;
        $order->user->fullname = $request->fullname;
        $order->user->username =  $order->user->username;
        $order->user->password =  $order->user->password;
        $order->user->status =  $order->user->status;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
   
    
        $order->user_id = $order->user_id;
        $order->created_at = $order->created_at; 
        $order->created_by = $order->created_by; 
        $order->status = $order->status; 
        $order->updated_by = $order->updated_by; 
        $order->updated_at = now();
        $order->save();
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công',
            'order' => $order
        ]);

        if ($order->isEmpty()) {
            $result = [
                'status' => false,
                'message' => 'Không tìm thấy dữ liệu',
                'order' => null
            ];
      
        }

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $order = Order::withTrashed()->find($id);
        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $order->forceDelete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công',
            'data' => null
        ]);
    }

    public function trash()
    {
        $orders = Order::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $orders
        ]);
    }

    public function status(string $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $order->status = ($order->status == 1) ? 2 : 1;
        $order->updated_by = Auth::id() ?? 1;
        $order->updated_at = date('Y-m-d H:i:s');
        
        if ($order->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thay đổi trạng thái thành công',
                'data' => $order
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể thay đổi trạng thái',
            'data' => null
        ]);
    }

    public function delete(string $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($order->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa tạm thời thành công',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể xóa',
            'data' => null
        ]);
    }

    public function restore(string $id)
    {
        $order = Order::withTrashed()->find($id);
        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($order->restore()) {
            return response()->json([
                'status' => true,
                'message' => 'Khôi phục thành công',
                'data' => $order
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể khôi phục',
            'data' => null
        ]);
    }

    public function ordersByUser(string $user_id)
    {
        $orders = Order::join('users', 'order.user_id', '=', 'users.id')
            ->where('order.user_id', $user_id)
            ->select('order.*', 'users.fullname', 'users.email as email', 'users.phone as phone', 'users.address as address')
            ->orderBy('order.created_at', 'DESC')
            ->paginate(10);



        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $orders
        ]);
    }
}
