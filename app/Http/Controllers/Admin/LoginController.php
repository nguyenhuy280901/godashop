<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    function index(){
        $data = [];
        return view('admin.login.index', $data);
    }

    public function login(Request $request)
    {
        $credential = $request->only('username', 'password');
        $remember_me = isset($request->remember_me);
        if(!Auth::guard('admin')->attempt($credential, $remember_me)) {
            $request->session()->put('error', 'Username hoặc password không chính xác');
        }elseif(Auth::guard('admin')->user()->is_active == 0) {
            Auth::guard('admin')->logout();
            $request->session()->put('error', 'Tài khoản của bạn chưa được active');
        }
        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login.form');
    }
}