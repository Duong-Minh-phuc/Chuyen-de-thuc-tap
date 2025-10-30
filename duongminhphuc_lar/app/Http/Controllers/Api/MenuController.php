<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('created_at', 'DESC') 
            ->select("id", "name", "link", "status", "type", "position","parent_id")
            ->where('status', 1)
            ->where('position', "mainmenu")
            ->paginate(20);
    
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $menus
        ]);
    }

    public function create() {
        return view('backend.menu.create');
    }

    public function store(Request $request)
    {
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->link = $request->link;
        $menu->type = $request->type;
        $menu->table_id = $request->table_id;
        $menu->position = $request->position;
        $menu->sort_order = $request->sort_order ?? 0;
        $menu->created_by = Auth::id() ?? 1;
        $menu->status = $request->status;

        if ($menu->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thêm thành công',
                'data' => $menu
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể thêm',
            'data' => null
        ]);
    }

    public function show(string $id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $menu
        ]);
    }

    public function edit(string $id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $menus = Menu::orderBy('sort_order', 'ASC')
            ->select("id", "name", "sort_order", "status")
            ->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => [
                'menu' => $menu,
                'menus' => $menus
            ]
        ]);
    }

    public function update(Request $request, string $id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $menu->name = $request->name;
        $menu->link = $request->link;
        $menu->type = $request->type;
        $menu->table_id = $request->table_id;
        $menu->position = $request->position;
        $menu->sort_order = $request->sort_order;
        $menu->updated_by = Auth::id() ?? 1;
        $menu->updated_at = date('Y-m-d H:i:s');
        $menu->status = $request->status;

        if ($menu->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thành công',
                'data' => $menu
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể cập nhật',
            'data' => null
        ]);
    }

    public function destroy(string $id)
    {
        $menu = Menu::withTrashed()->find($id);
        if (!$menu) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $menu->forceDelete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công',
            'data' => null
        ]);
    }

    public function trash()
    {
        $menus = Menu::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $menus
        ]);
    }

    public function status(string $id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $menu->status = ($menu->status == 1) ? 2 : 1;
        $menu->updated_by = Auth::id() ?? 1;
        $menu->updated_at = date('Y-m-d H:i:s');
        
        if ($menu->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thay đổi trạng thái thành công',
                'data' => $menu
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
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($menu->delete()) {
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
        $menu = Menu::withTrashed()->find($id);
        if (!$menu) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($menu->restore()) {
            return response()->json([
                'status' => true,
                'message' => 'Khôi phục thành công',
                'data' => $menu
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể khôi phục',
            'data' => null
        ]);
    }
}
