<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->is_admin){
            return [
                "sucees"=>true,
                "data"=>User::all()
            ];
        }
        else{
            return [
                "sucees"=>false,
                "data"=>"شما دسترسی لازم برای دریافت اطلاعات را ندارید"
            ];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->is_admin){
            $result = $this->validate($request,[
                "name"=>["required", "min:3","max:30"],
                "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u"],
                "email"=>["required","email"],
                "password"=>["required","confirmed"],
            ]);
            if($result){
                $user = User::create([
                    "name"=>$request->name,
                    "email"=>$request->email,
                    "phone"=>$request->phone,
                    "password"=>$request->password,
                    "is_active"=>($request->is_active == 1) ? true : false,
                    "is_admin"=>($request->is_admin == 1) ? true : false,
                ]);
                return [
                    "success"=>true,
                    "message"=>"کاربر با موفقیت اضافه گردید",
                    "data"=>$user
                ];
            }
            else{
                return [
                    "sucees"=>false,
                    "data"=>"اطلاعات ورودی اشتباه است"
                ];
            }
        }
        else{
            return [
                "sucees"=>false,
                "data"=>"شما دسترسی لازم برای دریافت اطلاعات را ندارید"
            ];
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
        if(auth()->user()->is_admin){
            $user = User::find($id);
            return [
                "success"=>true,
                "data"=>$user,
                "tasks"=>$user->tasks()->get()
            ];
        }
        else if(auth()->user()->id==$id){
            $user = User::find($id);
            return [
                "success"=>true,
                "data"=>$user,
                "tasks"=>$user->tasks()->get()
            ];
        }
        else{
            return [
                "success"=>false,
                "message"=>"شما دسترسی لازم برای این عملیات را ندارید"
            ];
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
        $result = $this->validate($request,[
            "name"=>["required", "min:3","max:30"],
            "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u"],
            "email"=>["required","email"],
            "password"=>["confirmed"],
        ]);

        if($result){
            $user = User::find($id);
            if(auth()->user()->is_admin){
                $user->update([
                    "name"=>$request->name,
                    "email"=>$request->email,
                    "phone"=>$request->phone,
                    "password"=>$request->password,
                    "is_active"=>($request->is_active == 1) ? true : false,
                    "is_admin"=>($request->is_admin == 1) ? true : false,
                ]);
                return [
                    "success"=>true,
                    "message"=>"کاربر با موفقیت ویرایش گردید",
                    "data"=>$user
                ];
            }
            else if(auth()->user()->id == $id){
                $user->update([
                    "name"=>$request->name,
                    "email"=>$request->email,
                    "phone"=>$request->phone,
                    "password"=>$request->password,
                ]);
                return [
                    "success"=>true,
                    "message"=>"کاربر با موفقیت ویرایش گردید",
                    "data"=>$user
                ];
            }
            else{
                return[
                    "success"=>false,
                    "message"=>"شما دسترسی لازم برای این عملیات را ندارید"
                ];
            }
        }
        else{
            return[
                "success"=>false,
                "message"=>"اطلاعات ورودی اشتباه است"
            ];
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
        if(auth()->user()->is_admin){
            $user = User::find($id);
            $user->delete();
            return[
                "success"=>true,
                "message"=>"کاربر با موفقیت حذف گردید"
            ];
        }
        else{
            return[
                "success"=>false,
                "message"=>"شما دسترسی لازم برای این عملیات را ندارید"
            ];
        }
    }
}
