<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login()
    {
        return view("backend.user.login");
    }

    function doLogin(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $data_login = [
            'username' => $username,
            'password' => $password,
        ];
        
        if (Auth::attempt($data_login)) {
            $request->session()->put('username', $username);
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('admin.login')->with('error', 'Thông tin không chính xác');
    }

    function logout()
    {
        Auth::logout();
        session()->forget('username');
        return redirect()->route('admin.login');
    }
} 