<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'phone'=>['required','regex:/^(\+98|0)?9\d{9}$/u'],
            'password'=>['required']
        ]);

        if($validator->fails()) {
            return response([
                "success"=>false,
                "meesage"=>"اطلاعات ورودی نامعتبر است",
                "errors"=>$validator->errors()->all()
            ],400);
        }
        else{

            if(!$token = JWTAuth::attempt($request->only('phone','password'))){
                return response([
                    "success"=>false,
                    "message"=>"نام کاربری یا رمز عبور اشتباه است"
                ],406);
            }
            else{
                return response([
                    "success"=>true,
                    "message"=>"شما با موفقیت وارد شدید",
                    "token"=>$token
                ],200);
            }
        }
    }

    public function logout(Request $request){
        $validator = Validator::make($request->all(),[
            'token'=>['required']
        ]);
        if($validator->fails()){
            return response([
                "success"=>false,
                "meesage"=>"اطلاعات ورودی نامعتبر است",
                "errors"=>$validator->errors()->all()
            ],400);
        }
        else{
            JWTAuth::invalidate($request->token);
            return response([
                "sucees"=>true,
                "message"=>"شما با موفقیت خارج شدید"
            ],200);
        }
    }
}
