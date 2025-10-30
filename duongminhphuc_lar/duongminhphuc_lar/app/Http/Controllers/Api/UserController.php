<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            ->select("id", "name", "email", "phone", "username", "address", "roles", "status")
            ->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $users
        ]);
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
        if (!$request->hasFile('image')) {
            return response()->json([
                'status' => false,
                'message' => 'Chưa chọn hình',
                'data' => null
            ]);
        }

        $user = new User();
        $file = $request->file('image');
        $extension = $file->extension();
        $filename = date('YmdHis') . "." . $extension;
        $file->move(public_path('images/user'), $filename);
        
        $user->image = $filename;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->roles = $request->roles;
        $user->created_by = Auth::id() ?? 1;
        $user->created_at = date('Y-m-d H:i:s');
        $user->status = $request->status;
        
        if($user->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thêm thành công',
                'data' => $user
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể thêm',
            'data' => null
        ]);
    }
    function doRegister(Request $request)
    {
        if (!$request->hasFile('thumbnail')) {
            return response()->json([
                'status' => false,
                'message' => 'Chưa chọn hình',
                'data' => null
            ]);
        }

        $user = new User();
        $file = $request->file('thumbnail');
        $extension = $file->extension();
        $filename = date('YmdHis') . "." . $extension;
        $file->move(public_path('images/user'), $filename);
        
        $user->thumbnail = $filename;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->roles = $request->roles;
        $user->created_by = Auth::id() ?? 1;
        $user->created_at = date('Y-m-d H:i:s');
        $user->status = $request->status;
        
        if($user->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thêm thành công',
                'data' => $user
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
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $user
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
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->username = $request->username;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->address = $request->address;
        $user->roles = $request->roles;

        if ($request->hasFile('image')) {
            if ($user->image && File::exists(public_path("images/user/" . $user->image))) {
                File::delete(public_path("images/user/" . $user->image));
            }
            $file = $request->file('image');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/user'), $filename);
            $user->image = $filename;
        }

        $user->updated_by = Auth::id() ?? 1;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->status = $request->status;

        if ($user->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thành công',
                'data' => $user
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
        $user = User::withTrashed()->find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($user->image && File::exists(public_path("images/user/" . $user->image))) {
            File::delete(public_path("images/user/" . $user->image));
        }
        
        $user->forceDelete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công',
            'data' => null
        ]);
    }

    public function status(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $user->status = ($user->status == 1) ? 2 : 1;
        $user->updated_by = Auth::id() ?? 1;
        $user->updated_at = date('Y-m-d H:i:s');
        
        if ($user->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thay đổi trạng thái thành công',
                'data' => $user
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
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($user->delete()) {
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

    public function trash()
    {
        $users = User::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $users
        ]);
    }

    public function restore(string $id)
    {
        $user = User::withTrashed()->find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($user->restore()) {
            return response()->json([
                'status' => true,
                'message' => 'Khôi phục thành công',
                'data' => $user
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể khôi phục',
            'data' => null
        ]);
    }
    function doLogin(Request $request)
{
    $username = $request->username;
    $password = $request->password;
    $args = [
        ['status', '=', 1],
    ];

    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $args[] = ['email', '=', $username];
    } else {
        $args[] = ['username', '=', $username];
    }

    $user = User::where($args)->first();
    if ($user != null) {
        if (Hash::check($password, $user->password)) {
            session()->put('user_site', $user);
            return response()->json([
                'status' => true,
                'message' => 'Đăng nhập thành công',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu không đúng',
                'data' => null
            ]);
        }
    } else {
            return response()->json([
                'status' => false,
                'message' => 'Tên đăng nhập hoặc email không tồn tại',
                'data' => null
            ]);
        }
    }
}