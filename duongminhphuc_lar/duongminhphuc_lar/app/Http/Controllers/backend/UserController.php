<?php

namespace App\Http\Controllers\backend;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')  
            ->select("id","fullname","thumbnail","roles","username", "email", "phone", "address", "status")
            ->paginate(5);
        return view('backend.user.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Lấy danh sách users để hiển thị
        $users = User::orderBy('created_at', 'DESC')
            ->select('id', 'fullname')
            ->get();
        
        // Lấy danh sách roles không trùng lặp
        $roles = User::select('roles')
            ->distinct()
            ->pluck('roles');

        return view('backend.user.create', compact('users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $users =new User();
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/user'), $filename);
            $users->thumbnail = $filename;
        }
        
        $users->fullname = $request->fullname;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $users->username = $request->username;
        $users->password = bcrypt($request->password);
        $users->roles = $request->roles;
        $users->address = 'Default Address'; // Mặc định
        $users->gender = 1; // Mặc định: Nam
        $users->created_by = Auth::id() ?? 1;
        $users->created_at = date('Y-m-d H:i:s');
        $users->status = $request->status;
        $users->save();
        
        return redirect()->route('admin.user.index')->with('success', 'Thêm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $users = User::where('id', $id)->first();
        if ($users == null) {
            return redirect()->back()->with('error', 'Không tồn tại mẫu tin');
        }
        return view('backend.user.show', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $user = User::where('id', $id)->first();
        return view('backend.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::where('id', $id)->first();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        //upload file
        if ($request->hasFile('thumbnail')) {
            //Xóa hình
            if ($user->thumbnail && File::exists(public_path("images/user/" . $user->thumbnail))) {
                File::delete(public_path("images/user/" . $user->thumbnail));
            }
            $file = $request->file('thumbnail');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/user'), $filename);
            $user->thumbnail = $filename;
        }
        //end upload file
        $user->roles = $request->roles;
        $user->updated_by = Auth::id() ?? 1;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->status = $request->status;
        if ($user->save()) {
            return redirect()->route('admin.user.index')->with('success', 'User update successfully');
        }
        return redirect()->back()->with('error', 'Failed to update user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $users = User::withTrashed()->where('id', $id)->first();
        if ($users != null) {
            //Xóa hình
            if ($users->image && File::exists(public_path("images/user/" . $users->image))) {
                File::delete(public_path("images/user/" . $users->image));
            }
            $users->forceDelete();
            return redirect()->route('admin.user.trash')->with('success', 'Xóa thành công');
        }
        return redirect()->route('admin.user.trash')->with('error', 'Mẫu tin không tồn tại');
    }
    public function status(string $id)
    {
        $user = User::find($id);
        if($user == null) {
            return redirect()->route('admin.user.index')
                ->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        // Chuyển đổi trạng thái
        $user->status = ($user->status == 1) ? 2 : 1;
        $user->updated_by = Auth::id() ?? 1;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();

        return redirect()->route('admin.user.index')
            ->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
    }

    public function delete(string $id) {
        $users = User::find($id);
        if($users == null) {
            return redirect()->route('admin.user.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $users->delete();
        return redirect()->route('admin.user.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công!']);
    }

    public function trash() {
        $users = User::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        return view('backend.user.trash', compact('users'));
    }

    public function restore(string $id)
    {
        $users = User::withTrashed()->where('id', $id);
        if ($users->first() != null) {
            $users->restore();
            return redirect()->route('admin.user.trash')->with('success', 'Khôi phục thành công');
        }
        return redirect()->route('admin.user.trash')->with('error', 'Mẫu tin không tồn tại');
    }
    //hhhhhh
}