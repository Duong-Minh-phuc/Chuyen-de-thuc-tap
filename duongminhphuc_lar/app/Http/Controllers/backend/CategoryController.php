<?php

namespace App\Http\Controllers\backend;
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
            ->select("id", "name","image","slug", "status","parent_id")
            ->paginate(5);
        
    
        return view('backend.category.index', compact('categories'));
        
     
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
        
        return view('backend.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $categories = new Category();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/category'), $filename);
            $categories->image = $filename;
            //
            $categories->name = $request->name;
            $categories->parent_id = $request->parent_id; // Thêm parent_id
            $categories->slug = $request->slug; // Thêm slug
            $categories->sort_order = $request->sort_order; // Thêm sort_order từ request
            $categories->description = $request->description;
            $categories->created_by = Auth::id() ?? 1;
            $categories->created_at = date('Y-m-d H:i:s');
            $categories->status = $request->status;
            $categories->save();
            return redirect()->route('admin.category.index')->with('success', 'Thêm thành công');
        }
        else
        {
            return back()->with('error', 'Chưa chọn hình');
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
        $categories = Category::where('id', $id)->first();
        if ($categories == null) {
            return redirect()->back()->with('error', 'Không tồn tại mẫu tin');
        }
        return view('backend.category.show', compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $category = Category::where('id', $id)->first();
        $categories = Category::orderBy('sort_order', 'ASC')
            ->select("id", "name", "sort_order", "status")
            ->get();
        
        return view('backend.category.edit', compact('category', 'categories'));
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
        $category = Category::where('id', $id)->first();
        $category->name = $request->name;
        $category->slug = $request->slug;
        //upload file
        if ($request->hasFile('image')) {
            //Xóa hình
            if ($category->image && File::exists(public_path("images/category/" . $category->image))) {
                File::delete(public_path("images/category/" . $category->image));
            }
            $file = $request->file('image');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/category'), $filename);
            $category->image = $filename;
        }
        //end upload file
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->sort_order = $request->sort_order;
        $category->updated_by = Auth::id() ?? 1;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->status = $request->status;
        if ($category->save()) {
            return redirect()->route('admin.category.index')->with('success', 'Category update successfully');
        }
        return redirect()->back()->with('error', 'Failed to update category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
{
    $categories = Category::withTrashed()->where('id', $id)->first();
    if ($categories != null) {
        //Xóa hình
        if ($categories->image && File::exists(public_path("images/category/" . $categories->image))) {
            File::delete(public_path("images/category/" . $category->image));
        }
        $categories->forceDelete();
        return redirect()->route('admin.category.trash')->with('success', 'Xóa thành công');
    }
    return redirect()->route('admin.category.trash')->with('error', 'Mẫu tin không tồn tại');
}

    public function trash() {
        $categories = Category::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        return view('backend.category.trash', compact('categories'));
    }

    public function status(string $id)
    {
        $category = Category::find($id);
        if($category == null) {
            return redirect()->route('admin.category.index')
                ->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        // Chuyển đổi trạng thái
        $category->status = ($category->status == 1) ? 2 : 1;
        $category->updated_by = Auth::id() ?? 1;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->save();

        return redirect()->route('admin.category.index')
            ->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
    }

    public function delete(string $id) {
        $categories = Category::find($id);
        if($categories == null) {
            return redirect()->route('admin.category.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $categories->delete();
        return redirect()->route('admin.category.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công!']);
    }

    public function restore(string $id)
    {
        $categories = Category::withTrashed()->where('id', $id);
        if ($categories->first() != null) {
            $categories->restore();
            return redirect()->route('admin.category.trash')->with('success', 'Khôi phục thành công');
        }
        return redirect()->route('admin.category.trash')->with('error', 'Mẫu tin không tồn tại');
    }
}
