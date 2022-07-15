<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

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
            return [
                "success"=>true,
                "data"=>Task::all(),
            ];
        }
        else{
            return [
                "success"=>true,
                "data"=>auth()->user()->tasks()->get(),
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
        $result = $this->validate($request,[
            "name"=>["required", "min:3","max:30"],
            "status"=>["required", "in:0,1,2"],
            "started_at"=>["required", "date","after:yesterday","before:finished_at"],
            "finished_at"=>["required", "date","after:started_at"],
        ]);

        if($result){
            if(auth()->user()->is_admin){
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
                    return [
                        "success"=>true,
                        "message"=>"وظیفه با موفقیت اضافه گردید",
                        "data"=>$task
                    ];
                }
                else{
                    $task = Task::create([
                        "name"=>$request->name,
                        "description"=>$request->description,
                        "status"=>$request->status,
                        "started_at"=>$request->started_at,
                        "finished_at"=>$request->finished_at
                    ]);
                    return [
                        "success"=>true,
                        "message"=>"وظیفه با موفقیت اضافه گردید",
                        "data"=>$task
                    ];
                }
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
                return [
                    "success"=>true,
                    "message"=>"وظیفه با موفقیت اضافه گردید",
                    "data"=>$task
                ];
            }
        }
        else{
            return [
                "success"=>false,
                "message"=>"اطلاعات وارد شده نادرست است"
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
        //
    }
}
