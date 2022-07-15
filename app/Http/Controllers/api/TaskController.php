<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

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
                "success"=>false,
                "message"=>"شما دسترسی لازم برای این عملیات را ندارید"
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
        //
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
        //
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
