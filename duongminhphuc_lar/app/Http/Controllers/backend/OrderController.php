<?php

namespace App\Http\Controllers\backend;
use App\Models\Order;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Order::query()
            ->with(['orderDetails'])
            ->orderBy('created_at', 'DESC');

        // Filter by status if provided
        if (request()->has('status')) {
            $query->where('status', request('status'));
        }

        $orders = $query->paginate(10);
        return view('backend.order.index', compact('orders'));
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
        // xử lý thêm
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        // Lấy thông tin đơn hàng
        $orders = Order::join('users', 'order.user_id', '=', 'users.id')
            ->where('order.id', $id)
            ->select('order.*', 'users.fullname', 'order.status as status_label')
            ->first();

        if (!$orders) {
            return redirect()->route('admin.order.index')->with('message', ['type' => 'danger', 'content' => 'Đơn hàng không tồn tại']);
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

        return view('backend.order.show', compact('orders', 'orderdetails'));
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
    public function update(Request $request, string $id)
    {
        // xử lý cập nhật
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    public function trash() {
        $orders = Order::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        return view('backend.order.trash', compact('orders'));
    }

    public function status(string $id)
    {
        $order = Order::find($id);
        if($order == null) {
            return redirect()->route('admin.order.index')
                ->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        // Chuyển đổi trạng thái
        $order->status = ($order->status == 1) ? 2 : 1;
        $order->updated_by = Auth::id() ?? 1;
        $order->updated_at = date('Y-m-d H:i:s');
        $order->save();

        return redirect()->route('admin.order.index')
            ->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
    }
    public function delete(string $id) {
        $orders = Order::find($id);
        if($orders == null) {
            return redirect()->route('admin.order.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $orders->delete();
        return redirect()->route('admin.order.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công!']);
    }

    public function restore(string $id)
    {
        $orders = Order::withTrashed()->where('id', $id);
        if ($orders->first() != null) {
            $orders->restore();
            return redirect()->route('admin.order.trash')->with('success', 'Khôi phục thành công');
        }
        return redirect()->route('admin.order.trash')->with('error', 'Mẫu tin không tồn tại');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer|min:0|max:8'
        ]);

        $order = Order::findOrFail($id);
        $newStatus = (int) $request->status;
        $oldStatus = $order->status;
        
        // Check if the status transition is valid
        if (!$order->canTransitionTo($newStatus)) {
            return back()->with('message', [
                'type' => 'danger',
                'content' => 'Không thể chuyển trạng thái đơn hàng từ ' .
                    $order->status_label . ' sang ' . Order::getStatusLabels()[$newStatus]
            ]);
        }

        try {
            // Update the status
            $order->status = $newStatus;
            $order->updated_at = now();
            $order->updated_by = auth()->id();
            $order->save();

            return back()->with('message', [
                'type' => 'success',
                'content' => 'Cập nhật trạng thái đơn hàng thành công'
            ]);
        } catch (\Exception $e) {
            return back()->with('message', [
                'type' => 'danger',
                'content' => 'Có lỗi xảy ra khi cập nhật trạng thái đơn hàng'
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            // Only allow deletion of cancelled or returned orders
            if (!in_array($order->status, [Order::STATUS_CANCELLED, Order::STATUS_RETURNED])) {
                return back()->with('message', [
                    'type' => 'danger',
                    'content' => 'Chỉ có thể xóa đơn hàng đã hủy hoặc đã hoàn trả'
                ]);
            }

            $order->delete();
            return redirect()->route('admin.order.index')->with('message', [
                'type' => 'success',
                'content' => 'Xóa đơn hàng thành công'
            ]);
        } catch (\Exception $e) {
            return back()->with('message', [
                'type' => 'danger',
                'content' => 'Có lỗi xảy ra khi xóa đơn hàng'
            ]);
        }
    }
}
