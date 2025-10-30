<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'DESC')
            ->select("id", "name", "image", "slug", "status", "parent_id")
            ->paginate(5);
        
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('created_at', 'DESC')
            ->select('id', 'name', 'sort_order')
            ->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        if (!$request->hasFile('image')) {
            return response()->json([
                'status' => false,
                'message' => 'Chưa chọn hình',
                'data' => null
            ]);
        }

        $categories = new Category();
        $file = $request->file('image');
        $extension = $file->extension();
        $filename = date('YmdHis') . "." . $extension;
        $file->move(public_path('images/category'), $filename);
        
        $categories->image = $filename;
        $categories->name = $request->name;
        $categories->parent_id = $request->parent_id;
        $categories->slug = $request->slug;
        $categories->sort_order = $request->sort_order;
        $categories->description = $request->description;
        $categories->created_by = Auth::id() ?? 1;
        $categories->created_at = date('Y-m-d H:i:s');
        $categories->status = $request->status;
        
        if($categories->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thêm thành công',
                'data' => $categories
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể thêm',
            'data' => null
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $category
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
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $categories = Category::orderBy('sort_order', 'ASC')
            ->select("id", "name", "sort_order", "status")
            ->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => [
                'category' => $category,
                'categories' => $categories
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $category->name = $request->name;
        $category->slug = $request->slug;

        if ($request->hasFile('image')) {
            if ($category->image && File::exists(public_path("images/category/" . $category->image))) {
                File::delete(public_path("images/category/" . $category->image));
            }
            $file = $request->file('image');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/category'), $filename);
            $category->image = $filename;
        }

        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->sort_order = $request->sort_order;
        $category->updated_by = Auth::id() ?? 1;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->status = $request->status;

        if ($category->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thành công',
                'data' => $category
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể cập nhật',
            'data' => null
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $category = Category::withTrashed()->find($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($category->image && File::exists(public_path("images/category/" . $category->image))) {
            File::delete(public_path("images/category/" . $category->image));
        }
        
        $category->forceDelete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công',
            'data' => null
        ]);
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $categories
        ]);
    }

    public function status(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $category->status = ($category->status == 1) ? 2 : 1;
        $category->updated_by = Auth::id() ?? 1;
        $category->updated_at = date('Y-m-d H:i:s');
        
        if ($category->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thay đổi trạng thái thành công',
                'data' => $category
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
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($category->delete()) {
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
        $category = Category::withTrashed()->find($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($category->restore()) {
            return response()->json([
                'status' => true,
                'message' => 'Khôi phục thành công',
                'data' => $category
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể khôi phục',
            'data' => null
        ]);
    }
}
