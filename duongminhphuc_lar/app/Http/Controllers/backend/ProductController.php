<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')
            ->select("id", "name", "category_id", "brand_id", "slug", "thumbnail", "status")
            ->with(['category', 'brand'])
            ->paginate(5);
        return view('backend.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('created_at', 'DESC')
            ->select('id', 'name')
            ->get();
        
        $brands = Brand::orderBy('created_at', 'DESC')
            ->select('id', 'name')
            ->get();
        
        return view('backend.product.create', compact('categories', 'brands'));
    }
    //Chi tiết sản phẩm
    public function store(StoreProductRequest $request)
    {
        $products= new Product();
        
        // Xử lý upload hình ảnh
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/product'), $filename);
            $products->thumbnail = $filename;
        }
        
        // Gán các giá trị từ request
        $products->name = $request->name;
        $products->slug = $request->slug;
        $products->description = $request->description;
        $products->content = $request->content;
        $products->price_buy = $request->price_buy;
        $products->price_sale = $request->price_sale;
        $products->qty = $request->qty;
        $products->category_id = $request->category_id;
        $products->brand_id = $request->brand_id;
        $products->created_by = Auth::id() ?? 1;
        $products->status = $request->status;
        
        // Lưu vào database
        $products->save();
        
        return redirect()->route('admin.product.index')->with('message', ['type' => 'success', 'msg' => 'Thêm sản phẩm thành công!']);
    }
    public function show(string $id)
    {
        $products = Product::where('id', $id)->first();
        if ($products == null) {
            return redirect()->back()->with('error', 'Không tồn tại mẫu tin');
        }
        return view('backend.product.show', compact('products'));
    }

    public function edit(string $id)
    {
        $product = Product::where('id', $id)->first();
        $categories = Category::orderBy('name', 'ASC')
            ->select("id", "name")
            ->get();
        $brands = Brand::orderBy('name', 'ASC')
            ->select("id", "name")
            ->get();
        
        return view('backend.product.edit', compact('product', 'categories', 'brands'));
    }
    //Xử lý cập nhật sản phâm

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::where('id', $id)->first();
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->content = $request->content;
        //upload file
        if ($request->hasFile('thumbnail')) {
            //Xóa hình
            if ($product->thumbnail && File::exists(public_path("images/product/" . $product->thumbnail))) {
                File::delete(public_path("images/product/" . $product->thumbnail));
            }
            $file = $request->file('thumbnail');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/product'), $filename);
            $product->thumbnail = $filename;
        }
        //end upload file
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->price_buy = $request->price_buy;
        $product->price_sale = $request->price_sale;
        $product->qty = $request->qty;
        $product->updated_by = Auth::id() ?? 1;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->status = $request->status;
        if ($product->save()) {
            return redirect()->route('admin.product.index')->with('success', 'Product update successfully');
        }
        return redirect()->back()->with('error', 'Failed to update product');
    }

    //xử lý cập nhật

    //Xóa sản phẩm khỏi CSDL

    public function destroy(string $id)
    {
        $products = Product::withTrashed()->where('id', $id)->first();
        if ($products != null) {
            //Xóa hình
            if ($products->image && File::exists(public_path("images/product/" . $products->image))) {
                File::delete(public_path("images/product/" . $product->image));
            }
            $products->forceDelete();
            return redirect()->route('admin.product.trash')->with('success', 'Xóa thành công');
        }
        return redirect()->route('admin.product.trash')->with('error', 'Mẫu tin không tồn tại');
    }

    //Danh sách sản phẩm rác

    public function trash()
    {
        $products = Product::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        return view('backend.product.trash', compact('products'));
    }
    public function status(string $id)
    {
        $product = Product::find($id);
        if($product == null) {
            return redirect()->route('admin.product.index')
                ->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        // Chuyển đổi trạng thái
        $product->status = ($product->status == 1) ? 2 : 1;
        $product->updated_by = Auth::id() ?? 1;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->save();

        return redirect()->route('admin.product.index')
            ->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
    }

    public function delete(string $id) {
        $products = Product::find($id);
        if($products == null) {
            return redirect()->route('admin.product.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $products->delete();
        return redirect()->route('admin.product.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công!']);
    }

    public function restore(string $id)
    {
        $products = Product::withTrashed()->where('id', $id);
        if ($products->first() != null) {
            $products->restore();
            return redirect()->route('admin.product.trash')->with('success', 'Khôi phục thành công');
        }
        return redirect()->route('admin.product.trash')->with('error', 'Mẫu tin không tồn tại');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
