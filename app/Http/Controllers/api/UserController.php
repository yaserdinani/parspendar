<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
            "name"=>["required","string","min:3","max:30"],
            "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u","unique:users"],
            "email"=>["required","email","unique:users"],
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
                "password"=>Hash::make($request->password),
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
    public function show(User $user)
    {
        return response([
            "success"=>true,
            "data"=>$user,
            "tasks"=>$user->tasks()->get()
        ],200);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {
        $validator = Validator::make($request->all(),[
            "name"=>["required", "min:3","max:30"],
            "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u",Rule::unique('users')->ignore($user->id)],
            "email"=>["required","email",Rule::unique('users')->ignore($user->id)],
            "password"=>["confirmed"],
        ]);
        if($validator->fails()){
            return response([
                "success"=>false,
                "message"=>"اطلاعات ورودی اشتباه است"
            ],400);
        }
        else{
            $user->update([
                "name"=>$request->name,
                "email"=>$request->email,
                "phone"=>$request->phone,
                "password"=>(isset($request->password) ? Hash::make($request->password) : $user->password),
                "is_active"=>($request->is_active == 1) ? true : false,
                "is_admin"=>($request->is_admin == 1) ? true : false,
            ]);
            return response([
                "success"=>true,
                "message"=>"کاربر با موفقیت ویرایش گردید",
                "data"=>$user
            ],200);
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
        $user->delete();
            return response([
                "success"=>true,
                "message"=>"کاربر با موفقیت حذف گردید"
            ],200);
    }
}
