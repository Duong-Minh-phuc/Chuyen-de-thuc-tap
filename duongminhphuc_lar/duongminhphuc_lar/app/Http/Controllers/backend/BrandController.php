<?php

namespace App\Http\Controllers\backend;
use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('created_at', 'DESC')
            ->select("id", "name","image","slug", "status")
            ->paginate(5);
        
    
        return view('backend.brand.index', compact('brands'));
        
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::orderBy('sort_order', 'ASC')
            ->select('id', 'name', 'sort_order')
            ->get();
        
        return view('backend.brand.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = new Brand();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/brand'), $filename);
            $brand->image = $filename;
            
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->sort_order = $request->sort_order;
            $brand->description = $request->description;
            $brand->created_by = Auth::id() ?? 1;
            $brand->created_at = date('Y-m-d H:i:s');
            $brand->status = $request->status;
            $brand->save();
            return redirect()->route('admin.brand.index')->with('success', 'Thêm thành công');
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
        $brands = Brand::where('id', $id)->first();
        if ($brands == null) {
            return redirect()->back()->with('error', 'Không tồn tại mẫu tin');
        }
        return view('backend.brand.show', compact('brands'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $brand = Brand::where('id', $id)->first();
        $brands = Brand::orderBy('sort_order', 'ASC')
            ->select("id", "name", "sort_order", "status")
            ->get();
        
        return view('backend.brand.edit', compact('brand', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        $brand = Brand::where('id', $id)->first();
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        //upload file
        if ($request->hasFile('image')) {
            //Xóa hình
            if ($brand->image && File::exists(public_path("images/brand/" . $brand->image))) {
                File::delete(public_path("images/brand/" . $brand->image));
            }
            $file = $request->file('image');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/brand'), $filename);
            $brand->image = $filename;
        }
        //end upload file
        $brand->description = $request->description;
        $brand->sort_order = $request->sort_order;
        $brand->updated_by = Auth::id() ?? 1;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->status = $request->status;
        if ($brand->save()) {
            return redirect()->route('admin.brand.index')->with('success', 'Brand update successfully');
        }
        return redirect()->back()->with('error', 'Failed to update brand');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
{
    $brands = Brand::withTrashed()->where('id', $id)->first();
    if ($brands != null) {
        //Xóa hình
        if ($brands->image && File::exists(public_path("images/brand/" . $brands->image))) {
            File::delete(public_path("images/brand/" . $brands->image));
        }
        $brands->forceDelete();
        return redirect()->route('admin.brand.trash')->with('success', 'Xóa thành công');
    }
    return redirect()->route('admin.brand.trash')->with('error', 'Mẫu tin không tồn tồn tại');
}

    public function trash() {
        $brands= Brand::onlyTrashed()
        ->orderBy('created_at', 'DESC')
        ->paginate(8);
    return view('backend.brand.trash', compact('brands'));
    }

    public function status(string $id)
    {
        $brand = Brand::find($id);
        if($brand == null) {
            return redirect()->route('admin.brand.index')
                ->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        // Chuyển đổi trạng thái
        $brand->status = ($brand->status == 1) ? 2 : 1;
        $brand->updated_by = Auth::id() ?? 1;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->save();

        return redirect()->route('admin.brand.index')
            ->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
    }

    public function delete(string $id) {
        $brands = Brand::find($id);
                    if($brands == null) {
            return redirect()->route('admin.brand.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $brands->delete();
        return redirect()->route('admin.brand.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công!']);
    }

    public function restore(string $id)
    {
        $brands = Brand::withTrashed()->where('id', $id);
        if ($brands->first() != null) {
            $brands->restore();
            return redirect()->route('admin.brand.trash')->with('success', 'Khôi phục thành công');
        }
        return redirect()->route('admin.brand.trash')->with('error', 'Mẫu tin không tồn tại');
    }
}
