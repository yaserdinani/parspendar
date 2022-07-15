<?php

namespace App\Http\Controllers\panel;

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
            $tasks = Task::paginate();
        }
        else{
            $tasks = auth()->user()->tasks()->paginate();
        }

        return view('task.index')->with('tasks', $tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->is_admin){
            $users = User::all();
            return view('task.create')->with('users', $users);
        }
        else{
            return view('task.create');
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
        $this->validate($request,[
            "name"=>["required", "min:3","max:30"],
            "status"=>["required", "in:0,1,2"],
            "started_at"=>["required", "date","after:yesterday","before:finished_at"],
            "finished_at"=>["required", "date","after:started_at"],
        ]);
        
        if(auth()->user()->is_admin){
            if(isset($request->users)){
                $task = Task::create([
                    "name"=>$request->name,
                    "description"=>$request->description,
                    "status"=>$request->status,
                    "started_at"=>$request->started_at,
                    "finished_at"=>$request->finished_at
                ]);
                $users = User::find($request->users);
                $task->users()->attach($users);
                return redirect()->route('tasks.index');
            }
            else{
                $task = Task::create([
                    "name"=>$request->name,
                    "description"=>$request->description,
                    "status"=>$request->status,
                    "started_at"=>$request->started_at,
                    "finished_at"=>$request->finished_at
                ]);
                return redirect()->route('tasks.index');
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
            return redirect()->route('tasks.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('task.show')->with("task",$task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $users = User::all();

        return view('task.edit',["users"=>$users,"task"=>$task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request,[
            "name"=>["required", "min:3","max:30"],
            "status"=>["required", "in:0,1,2"],
            "started_at"=>["required", "date","after:yesterday","before:finished_at"],
            "finished_at"=>["required", "date","after:started_at"],
        ]);

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
                $task->users()->attach(User::find($request->users));
                return redirect()->route('tasks.index');

            }
            else{
                $task->update([
                    "name"=>$request->name,
                    "description"=>$request->description,
                    "status"=>$request->status,
                    "started_at"=>$request->started_at,
                    "finished_at"=>$request->finished_at
                ]);
                return redirect()->route('tasks.index');
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
            return redirect()->route('tasks.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->users()->detach($task->users()->get());
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
