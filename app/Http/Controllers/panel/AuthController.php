<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){

        $this->validate($request,[
            'phone'=>['required','regex:/^(\+98|0)?9\d{9}$/u'],
            'password'=>['required']
        ]);

        if(!auth()->attempt($request->only('phone','password'))){
            return back()->with("message","نام کاربری یا رمز عبور اشتباه است");
        }

        else{
            return redirect()->route('dashboard');
        }
    }

    public function logout(){
        auth()->logout();

        return redirect()->route('auth.index');
    }
}
