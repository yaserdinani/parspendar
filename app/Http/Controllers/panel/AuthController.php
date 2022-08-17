<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){

        $validate_data = $this->validate($request,[
            'phone'=>['required','regex:/^(\+98|0)?9\d{9}$/u'],
            'password'=>['required']
        ]);
        if(!auth()->attempt($request->only('phone','password'))){
            return back()->with("message","نام کاربری یا رمز عبور اشتباه است");
        }

        else{
            return redirect()->route('livewire.tasks.index');
        }
    }

    public function logout(){
        auth()->logout();

        return redirect()->route('auth.index');
    }
}
