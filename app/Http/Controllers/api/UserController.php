<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            "sucees"=>true,
            "data"=>User::all()
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name"=>["required", "min:3","max:30"],
            "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u"],
            "email"=>["required","email"],
            "password"=>["required","confirmed"],
        ]);
        if($validator->fails()){
            return response([
                "success"=>false,
                "meesage"=>"اطلاعات ورودی نامعتبر است",
                "errors"=>$validator->errors()->all()
            ],400);
        }
        else{
            $user = User::create([
                "name"=>$request->name,
                "email"=>$request->email,
                "phone"=>$request->phone,
                "password"=>$request->password,
                "is_active"=>($request->is_active == 1) ? true : false,
                "is_admin"=>($request->is_admin == 1) ? true : false,
            ]);
            return response([
                "success"=>true,
                "message"=>"کاربر با موفقیت اضافه گردید",
                "data"=>$user
            ],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user){
            return response([
                "success"=>true,
                "data"=>$user,
                "tasks"=>$user->tasks()->get()
            ],200);
        }
        else{
            return response([
                "success"=>false,
                "message"=>"کاربر یافت نشد"
            ],404);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "name"=>["required", "min:3","max:30"],
            "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u"],
            "email"=>["required","email"],
            "password"=>["confirmed"],
        ]);
        if($validator->fails()){
            return response([
                "success"=>false,
                "message"=>"اطلاعات ورودی اشتباه است"
            ],400);
        }
        else{
            $user = User::find($id);
            if($user){
                $user->update([
                    "name"=>$request->name,
                    "email"=>$request->email,
                    "phone"=>$request->phone,
                    "password"=>$request->password,
                    "is_active"=>($request->is_active == 1) ? true : false,
                    "is_admin"=>($request->is_admin == 1) ? true : false,
                ]);
                return response([
                    "success"=>true,
                    "message"=>"کاربر با موفقیت ویرایش گردید",
                    "data"=>$user
                ],200);
            }
            else{
                return response([
                    "success"=>false,
                    "message"=>"کاربر یافت نشد"
                ],404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user  = User::find($id);
        if($user){
            $user->delete();
            return response([
                "success"=>true,
                "message"=>"کاربر با موفقیت حذف گردید"
            ],200);
        }
        else{
            return response([
                "success"=>false,
                "message"=>"کاربر یافت نشد"
            ],404);
        }
    }
}
