<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Đảm bảo bạn đã import Auth
use Illuminate\Support\Facades\Hash; 

class UserController extends Controller
{
    function login()
{
    return view('frontend.login');
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
            return redirect()->route('site.home')->with('success', 'Đăng nhập thành công');
        } else {
            return redirect()->route('site.login')->with('error', 'Mật khẩu không đúng');
        }
    } else {
            return redirect()->route('site.login')->with('error', 'Tên đăng nhập hoặc email không tồn tại');
        }
    }
    function logout()
    {
        // Xóa thông tin người dùng khỏi session
        session()->forget('user_site');
        
        // Đăng xuất người dùng
        Auth::logout();
        
        // Chuyển hướng về trang đăng nhập
        return redirect()->route('site.login')->with('success', 'Đăng xuất thành công');
    }
    function register()
    {
        return view('frontend.register'); // Return the registration view
    }

    function doRegister(Request $request)
    {
        // Validate the request
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Hash the password
        $user->save();

        return redirect()->route('site.login')->with('success', 'Đăng ký thành công, vui lòng đăng nhập');
    }
    

    
}



