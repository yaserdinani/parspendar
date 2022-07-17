<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->is_admin){
            return response([
                "success"=>true,
                "data"=>Task::all(),
            ],200);
        }
        else{
            return response([
                "success"=>true,
                "data"=>auth()->user()->tasks()->get(),
            ],200);
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
        $validator = Validator::make($request->all(),[
            "name"=>["required", "min:3","max:30"],
            "status"=>["required", "in:0,1,2"],
            "started_at"=>["required", "date","after:yesterday","before:finished_at"],
            "finished_at"=>["required", "date","after:started_at"],
        ]);
        if($validator->fails()){
            return response([
                "success"=>false,
                "message"=>"اطلاعات ورودی اشتباه است"
            ],400);
        }
        else{
            if(isset($request->users)){
                $task = Task::create([
                    "name"=>$request->name,
                    "description"=>$request->description,
                    "status"=>$request->status,
                    "started_at"=>$request->started_at,
                    "finished_at"=>$request->finished_at
                ]);
                $users = User::find(json_decode($request->users));
                $task->users()->attach($users);
                return response([
                    "success"=>true,
                    "message"=>"وظیفه با موفقیت اضافه گردید",
                    "data"=>$task
                ],200);
            }
            else{
                $task = Task::create([
                    "name"=>$request->name,
                    "description"=>$request->description,
                    "status"=>$request->status,
                    "started_at"=>$request->started_at,
                    "finished_at"=>$request->finished_at
                ]);
                $task->users()->attach(auth()->user());
                return response([
                    "success"=>true,
                    "message"=>"وظیفه با موفقیت اضافه گردید",
                    "data"=>$task
                ],200);
            }
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
        $task = Task::find($id);
        if(auth()->user()->is_admin){
            return [
                "success"=>true,
                "data"=>$task,
                "users"=>$task->users()->get()
            ];
        }
        else if($task->users()->where('user_id',auth()->user()->id)->exists()){
            return [
                "success"=>true,
                "data"=>$task,
                "users"=>$task->users()->get()
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
            "status"=>["required", "in:0,1,2"],
            "started_at"=>["required", "date","after:yesterday","before:finished_at"],
            "finished_at"=>["required", "date","after:started_at"],
        ]);
        if($result){
            $task = Task::find($id);
            if(auth()->user()->is_admin){
                if(isset($request->users)){
                    $task->update([
                        "name"=>$request->name,
                        "description"=>$request->description,
                        "status"=>$request->status,
                        "started_at"=>$request->started_at,
                        "finished_at"=>$request->finished_at
                    ]);
                    $task->users()->detach($task->users()->get());
                    $task->users()->attach(User::find(json_decode($request->users)));
                    return [
                        "success"=>true,
                        "message"=>"وظیفه با موفقیت ویرایش گردید",
                        "data"=>$task
                    ];
    
                }
                else{
                    $task->update([
                        "name"=>$request->name,
                        "description"=>$request->description,
                        "status"=>$request->status,
                        "started_at"=>$request->started_at,
                        "finished_at"=>$request->finished_at
                    ]);
                    return [
                        "success"=>true,
                        "message"=>"وظیفه با موفقیت ویرایش گردید",
                        "data"=>$task
                    ];
                }
            }
            else{
                $task->update([
                    "name"=>$request->name,
                    "description"=>$request->description,
                    "status"=>$request->status,
                    "started_at"=>$request->started_at,
                    "finished_at"=>$request->finished_at
                ]);
                return [
                    "success"=>true,
                    "message"=>"وظیفه با موفقیت ویرایش گردید",
                    "data"=>$task
                ];
            }
        }
        else{
            return [
                "success"=>false,
                "message"=>"اطلاعات ورودی نادرست است"
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
        $task = Task::find($id);
        if(auth()->user()->is_admin){
            $task->users()->detach($task->users()->get());
            $task->delete();
            return [
                "success" =>true,
                "message" => "وظیفه با موفقیت حذف گردید"
            ];
        }
        else if($task->users()->where('user_id',auth()->user()->id)->exists()){
            $task->users()->detach($task->users()->get());
            $task->delete();
            return [
                "success" =>true,
                "message" => "وظیفه با موفقیت حذف گردید"
            ];
        }
        else{
            return [
                "success" =>false,
                "message" => "شما دسترسی لازم برای انجام این عملیات را ندارید"
            ];
        }
    }

    public function filter(Request $request){
            if(auth()->user()->is_admin){
                if(isset($request->status)){
                    $tasks = Task::select("*")->where("status","=",$request->status)->get();
                    return[
                        "success"=>true,
                        "data"=>$tasks
                    ];
                }
                else if (isset($request->started_at) && isset($request->finished_at)){
                    $tasks = Task::select("*")
                    ->where("started_at",">=",$request->started_at)
                    ->where("finished_at","<=",$request->finished_at)
                    ->get();
                    return[
                        "success"=>true,
                        "data"=>$tasks
                    ];
                }
                else if(isset($request->started_at)){
                    $tasks = Task::select("*")->where("started_at",">=",$request->started_at)->get();
                    return[
                        "success"=>true,
                        "data"=>$tasks
                    ];
                }
                else if(isset($request->finished_at)){
                    $tasks = Task::select("*")->where("finished_at",">=",$request->finished_at)->get();
                    return[
                        "success"=>true,
                        "data"=>$tasks
                    ];
                }
                else{
                    $tasks = Task::all();
                    return[
                        "success"=>true,
                        "data"=>$tasks
                    ];
                }
            }
            else{
                return [
                    "success"=>false,
                    "message"=>"شما دسترسی لازم برای این کار را ندارید"
                ];
            }
    }
}
