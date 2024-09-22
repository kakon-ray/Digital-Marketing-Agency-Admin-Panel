<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{
    public function create()
    {
        return view('admin.auth.login');
    }


    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'superadmin']) || Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin'])) {
            // return redirect('admin/dashboard');
            $arr = array('status' => 200, 'msg' => 'Login Successed');
            return \Response::json($arr);
        } else {
            // return back()->with('error','Invalid Username and Passsword');
            $arr = array('status' => 400, 'msg' => 'Login Faild');
            return \Response::json($arr);
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/login');
    }
}
