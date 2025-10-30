<?php

namespace App\Http\Controllers\backend;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'DESC')
            ->select("id", "name", "link", "image", "position", "status")
            ->paginate(5);
        
    
        return view('backend.banner.index', compact('banners'));
        
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Lấy danh sách banner để hiển thị sort_order
        $banners = Banner::orderBy('sort_order', 'ASC')
                        ->select('id', 'name', 'sort_order')
                        ->get();
    
        // Lấy danh sách vị trí không trùng lặp
        $positions = Banner::select('position')
                        ->distinct()
                        ->pluck('position');

        return view('backend.banner.create', compact('banners', 'positions'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBannerRequest $request)
    {
        $banners = new Banner();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/banner'), $filename);
            $banners->image = $filename;
            //
            $banners->name = $request->name;
            $banners->link = $request->link;
            $banners->position = $request->position;
            $banners->description = $request->description;
            $banners->sort_order = 0;
            $banners->created_by = Auth::id() ?? 1;
            $banners->created_at = date('Y-m-d H:i:s');
            $banners->status = $request->status;
            $banners->save();
            return redirect()->route('admin.banner.index')->with('success', 'Thêm thành công');
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
        $banners = Banner::where('id', $id)->first();
        if ($banners == null) {
            return redirect()->back()->with('error', 'Không tồn tại mẫu tin');
        }
        return view('backend.banner.show', compact('banners'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $banner = Banner::where('id', $id)->first();
        $banners = Banner::orderBy('sort_order', 'ASC')
            ->select("id", "name", "sort_order", "status")
            ->get();
        
        return view('backend.banner.edit', compact('banner', 'banners'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBannerRequest $request, string $id)
    {
        $banner = Banner::where('id', $id)->first();
        $banner->name = $request->name;
        $banner->link = $request->link;
        //upload file
        if ($request->hasFile('image')) {
            //Xóa hình
            if ($banner->image && File::exists(public_path("images/banner/" . $banner->image))) {
                File::delete(public_path("images/banner/" . $banner->image));
            }
            $file = $request->file('image');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/banner'), $filename);
            $banner->image = $filename;
        }
        //end upload fiel
        $banner->position = $request->position;
        $banner->description = $request->description;
        $banner->sort_order = $request->sort_order;
        $banner->updated_by = Auth::id() ?? 1;
        $banner->updated_at = date('Y-m-d H:i:s');
        $banner->status = $request->status;
        if ($banner->save()) {
            return redirect()->route('admin.banner.index')->with('success', 'Banner update successfully');
        }
        return redirect()->back()->with('error', 'Failed to create banner');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $banners = Banner::withTrashed()->where('id', $id)->first();
        if ($banners != null) {
            //Xóa hình
            if ($banners->image && File::exists(public_path("images/banner/" . $banners->image))) {
                File::delete(public_path("images/banner/" . $banners->image));
            }
            $banners->forceDelete();
                return redirect()->route('admin.banner.trash')->with('success', 'Xóa thành công');
        }                       
        return redirect()->route('admin.banner.trash')->with('error', 'Mẫu tin không tồn tại');
    }
    public function trash()
    {
        $banners = Banner::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        return view('backend.banner.trash', compact('banners'));
    }

    public function status(string $id)
    {
        $banner = Banner::find($id);
        if($banner == null) {
            return redirect()->route('admin.banner.index')
                ->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        // Chuyển đổi trạng thái
        $banner->status = ($banner->status == 1) ? 2 : 1;
        $banner->updated_by = Auth::id() ?? 1;
        $banner->updated_at = date('Y-m-d H:i:s');
        $banner->save();

        return redirect()->route('admin.banner.index')
            ->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
    }

    public function delete(string $id) {
        $banners = Banner::find($id);
        if($banners == null) {
            return redirect()->route('admin.banner.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $banners->delete();
        return redirect()->route('admin.banner.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công!']);
    }
    
    public function restore(string $id)
    {
        $banners = Banner::withTrashed()->where('id', $id);
        if ($banners->first() != null) {
            $banners->restore();
            return redirect()->route('admin.banner.trash')->with('success', 'Khôi phục thành công');
        }
        return redirect()->route('admin.banner.trash')->with('error', 'Mẫu tin không tồn tại');
    }
}
