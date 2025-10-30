<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (session('user_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('backend.user.login');
    }

    public function dologin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)
                    ->where('status', 1)
                    ->whereIn('roles', ['admin', 'superadmin'])
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            
            // Thiết lập session với thời gian dài hơn (48 giờ)
            $request->session()->put([
                'user_id' => $user->id,
                'username' => $user->username,
                'fullname' => $user->fullname,
                'roles' => $user->roles
            ]);
            
            // Tăng thời gian session
            config(['session.lifetime' => 2880]); // 48 giờ
            
            return redirect()->route('admin.dashboard')
                           ->with('success', 'Đăng nhập thành công!');
        }

        return redirect()->route('admin.login')
                        ->with('error', 'Tên đăng nhập hoặc mật khẩu không đúng!');
    }

    public function logout()
    {
        Session::flush(); // Xóa tất cả session
        Auth::logout();
        return redirect()->route('admin.login')
                        ->with('success', 'Đăng xuất thành công!');
    }
} 