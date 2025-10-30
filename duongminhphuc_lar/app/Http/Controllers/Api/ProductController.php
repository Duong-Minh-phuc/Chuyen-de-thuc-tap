<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('products.status', 1)
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->select("products.id","products.content","brands.slug as brand_slug","products.description", "category_id", "brand_id","categories.name as category_name","categories.slug as category_slug", "brands.name as brand_name", "brands.slug as brand_slug", "products.name", "products.slug", "products.thumbnail", "products.price_buy", "products.price_sale", "products.status", "products.qty")
          
            ->paginate(20);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $products
        ]);
    }
        public function category(string $slug)
        {
            $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->where('categories.slug', $slug)
                ->where('products.status', 1)
                ->select("products.id","products.content","brands.slug as brand_slug","products.description", "category_id", "brand_id","categories.name as category_name","categories.slug as category_slug", "brands.name as brand_name", "brands.slug as brand_slug", "products.name", "products.slug", "products.thumbnail", "products.price_buy", "products.price_sale", "products.status", "products.qty")
                ->paginate(20);
            
            return response()->json([
                'status' => true,
                'message' => 'Lấy dữ liệu thành công',
                'data' => $products
            ]);
        }
        public function brand(string $slug)
        {
            $products = Product::join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('brands.slug', $slug)
                ->where('products.status', 1)
                ->select("products.id","products.content","brands.slug as brand_slug","products.description", "category_id", "brand_id","categories.name as category_name","categories.slug as category_slug", "brands.name as brand_name", "brands.slug as brand_slug", "products.name", "products.slug", "products.thumbnail", "products.price_buy", "products.price_sale", "products.status", "products.qty")
                ->paginate(20);
            return response()->json([
                'status' => true,
                'message' => 'Lấy dữ liệu thành công',
                'data' => $products
            ]);
        }
    public function detail(string $slug)
    {
        $product = Product::where('products.slug', $slug)
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('brands', 'products.brand_id', '=', 'brands.id')
        ->select("products.id", "category_id","products.content","products.view_count","products.description",  "brand_id","categories.name as category_name", "brands.name as brand_name", "products.name", "products.slug", "products.thumbnail", "products.price_buy", "products.price_sale", "products.status", "products.qty")
        ->first();

        // Tăng số lượt xem
        $product->increment('view_count');
       

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $product
        ]);
    }
   public function new()
   {
    $products = Product::orderBy('products.created_at', 'DESC')
    ->join('categories', 'products.category_id', '=', 'categories.id')
    ->join('brands', 'products.brand_id', '=', 'brands.id')
    ->where('products.status', 1)
    ->select("products.id", "category_id", "brand_id","categories.name as category_name", "brands.name as brand_name", "products.name", "products.slug", "products.thumbnail", "products.price_buy", "products.price_sale", "products.status", "products.qty")
    ->paginate(20);
    return response()->json([
        'status' => true,
        'message' => 'Lấy dữ liệu thành công',
        'data' => $products
    ]);
   }
    public function sale()
    {
        $products = Product::where('products.price_sale', '!=', 0)
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                "products.id", 
                "category_id", 
                "brand_id",
                "categories.name as category_name", 
                "brands.name as brand_name", 
                "products.name", 
                "products.slug", 
                "products.thumbnail", 
                "products.price_buy", 
                "products.price_sale", 
                "products.status", 
                "products.qty"
            )
            ->orderBy('products.price_sale', 'desc')
            ->paginate(20);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $products
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')
            ->select('id', 'name')
            ->get();
        
        $brands = Brand::orderBy('name', 'ASC')
            ->select('id', 'name')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => [
                'categories' => $categories,
                'brands' => $brands
            ]
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        if (!$request->hasFile('image')) {
            return response()->json([
                'status' => false,
                'message' => 'Chưa chọn hình',
                'data' => null
            ]);
        }

        $product = new Product();
        $file = $request->file('image');
        $extension = $file->extension();
        $filename = date('YmdHis') . "." . $extension;
        $file->move(public_path('images/product'), $filename);
        
        $product->image = $filename;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->price_sale = $request->price_sale;
        $product->detail = $request->detail;
        $product->description = $request->description;
        $product->created_by = Auth::id() ?? 1;
        $product->created_at = date('Y-m-d H:i:s');
        $product->status = $request->status;
        
        if($product->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thêm thành công',
                'data' => $product
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
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $product
        ]);
    }

    public function edit(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $categories = Category::orderBy('name', 'ASC')
            ->select('id', 'name')
            ->get();
        
        $brands = Brand::orderBy('name', 'ASC')
            ->select('id', 'name')
            ->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => [
                'product' => $product,
                'categories' => $categories,
                'brands' => $brands
            ]
        ]);
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->price_sale = $request->price_sale;
        $product->detail = $request->detail;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path("images/product/" . $product->image))) {
                File::delete(public_path("images/product/" . $product->image));
            }
            $file = $request->file('image');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/product'), $filename);
            $product->image = $filename;
        }

        $product->updated_by = Auth::id() ?? 1;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->status = $request->status;

        if ($product->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thành công',
                'data' => $product
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
        $product = Product::withTrashed()->find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($product->image && File::exists(public_path("images/product/" . $product->image))) {
            File::delete(public_path("images/product/" . $product->image));
        }
        
        $product->forceDelete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công',
            'data' => null
        ]);
    }

    public function trash()
    {
        $products = Product::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $products
        ]);
    }

    public function status(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $product->status = ($product->status == 1) ? 2 : 1;
        $product->updated_by = Auth::id() ?? 1;
        $product->updated_at = date('Y-m-d H:i:s');
        
        if ($product->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thay đổi trạng thái thành công',
                'data' => $product
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
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($product->delete()) {
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
        $product = Product::withTrashed()->find($id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($product->restore()) {
            return response()->json([
                'status' => true,
                'message' => 'Khôi phục thành công',
                'data' => $product
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể khôi phục',
            'data' => null
        ]);
    }
    public function searchNameProduct(Request $request, $keyword = null)
    {
        $search = $keyword ?? trim($request->input('search'));
    
        if (empty($search)) {
            return response()->json([
                'status' => true,
                'message' => 'Không có từ khóa tìm kiếm',
                'data' => []
            ]);
        }
    
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('products.name', 'LIKE', "%{$search}%")
            ->where('products.status', 1)
            ->select(
                "products.id", "products.category_id", "products.brand_id", "products.name",
                "categories.name as category_name", "brands.name as brand_name",
                "products.slug", "products.content", "products.qty", "products.price_buy", "products.price_sale", 
                "products.status", "products.description", "products.thumbnail"
            )
            ->orderBy('products.created_at', 'DESC')
            ->paginate(12);
    
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $products
        ]);
    }
   
}
