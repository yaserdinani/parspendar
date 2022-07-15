<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request){
        $result = $this->validate($request,[
            'phone'=>['required','regex:/^(\+98|0)?9\d{9}$/u'],
            'password'=>['required']
        ]);

        if($result){
            if(!$token = JWTAuth::attempt($request->only('phone','password'))){
                return ["success"=>false,"message"=>"نام کاربری یا رمز عبور اشتباه است"];
            }
    
            else{
                return ["success"=>true,"message"=>"شما با موفقیت وارد شدید", "token"=>$token];
            }
        }
        else{
            return [
                "sucees"=>false,
                "message"=>"اطلاعات ورودی نامعتبر است"
            ];
        }
    }

    public function logout(Request $request){
        $result = $this->validate($request,[
            'token'=>['required']
        ]);
        if($result){
            JWTAuth::invalidate($request->token);
            return [
                "sucees"=>true,
                "message"=>"شما با موفقیت خارج شدید"
            ];
        }
        else{
            return [
                "sucees"=>false,
                "message"=>"اطلاعات ورودی نامعتبر است"
            ];
        }
    }
}
