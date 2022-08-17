<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Carbon\Carbon;

class Index extends Component
{

    public $tasks;
    public $current_task;
    public $name;
    public $description;
    public $users = [];
    public $started_at;
    public $finished_at;
    public $status;
    public $statuses;
    public $all_users;
    public $start_time;
    public $finish_time;

    protected $listeners = ["taskAdded","taskChanged","taskRemoved","setStartedAt","setFinishedAt"];

    public function resetInputs(){
        $this->current_task = null;
        $this->name = null;
        $this->description = null;
        $this->users = [auth()->user()->id];
        $this->started_at = null;
        $this->finished_at = null;
        $this->status = null;
        $this->start_time = null;
        $this->finish_time = null;
    }

    public function mount(){
        if(auth()->user()->can('add-task-for-users')){
            $this->all_users = User::all();
        }
        if(auth()->user()->can('see-all-tasks')){
            $this->tasks = Task::all();
        }
        else{
            $this->tasks = auth()->user()->tasks;
        }
        $this->statuses = TaskStatus::all();
        $this->users = [auth()->user()->id];
    }

    public function taskAdded(){
        if(auth()->user()->can('see-all-tasks')){
            $this->tasks = Task::all();
        }
        else{
            $this->tasks = auth()->user()->tasks;
        }
    }

    public function taskRemoved(){
        if(auth()->user()->can('see-all-tasks')){
            $this->tasks = Task::all();
        }
        else{
            $this->tasks = auth()->user()->tasks;
        }
    }

    public function taskChanged(){
        if(auth()->user()->can('see-all-tasks')){
            $this->tasks = Task::all();
        }
        else{
            $this->tasks = auth()->user()->tasks;
        }
    }
    
    public function setCurrentTask(Task $task){
        $this->currentTask = $task;
        $this->name = $task->name;
        $this->description = $task->description;
        $this->status = $task->task_status_id;
        $this->started_at = $task->started_at;
        $this->finished_at = $task->finished_at;
        $this->start_time  = \Morilog\Jalali\Jalalian::forge($task->started_at)->format('%A %d %B %Y');
        $this->finish_time  = \Morilog\Jalali\Jalalian::forge($task->finished_at)->format('%A %d %B %Y');
        $this->users = $task->users()->get()->pluck('id');
    }

    public function delete(){
        abort_unless(auth()->user()->can('task-delete'), '403', 'Unauthorized.');
        $this->currentTask->delete();
        $this->resetInputs();
        $this->emit('taskRemoved');
    }

    public function store(){
        abort_unless(auth()->user()->can('task-create'), '403', 'Unauthorized.');
        $this->started_at = Carbon::parse($this->started_at);
        $this->finished_at = Carbon::parse($this->finished_at);

        $validateData = $this->validate([
            "name"=>["required", "min:3","max:30"],
            "status"=>["required", "exists:task_statuses,id"],
            "started_at"=>["required", "date","after:yesterday","before:finished_at"],
            "finished_at"=>["required", "date","after:started_at"],
            "description"=>["min:10","max:200"],
            "users"=>["exists:users,id"],
        ]);

        $task = Task::create([
            "name"=>$this->name,
            "task_status_id"=>$this->status,
            "description"=>$this->description,
            "started_at"=>$this->started_at,
            "finished_at"=>$this->finished_at,
        ]);

        $task->users()->sync($this->users);
        $this->resetInputs();
        $this->emit('taskAdded');
    }

    public function update(){
        abort_unless(auth()->user()->can('task-edit'), '403', 'Unauthorized.');
        $this->started_at = Carbon::parse($this->started_at);
        $this->finished_at = Carbon::parse($this->finished_at);
        $validateData = $this->validate([
            "name"=>["required", "min:3","max:30"],
            "status"=>["required", "exists:task_statuses,id"],
            "started_at"=>["required", "date","after:yesterday","before:finished_at"],
            "finished_at"=>["required", "date","after:started_at"],
            "description"=>["min:10","max:200"],
            "users"=>["exists:users,id"],
        ]);

        $this->currentTask->update([
            "name"=>$this->name,
            "task_status_id"=>$this->status,
            "description"=>$this->description,
            "started_at"=>$this->started_at,
            "finished_at"=>$this->finished_at,
        ]);

        $this->currentTask->users()->sync($this->users);
        $this->resetInputs();
        $this->emit('taskChanged');
    }

    public function render()
    {
        abort_unless(auth()->user()->can('task-list'), '403', 'Unauthorized.');
        return view('livewire.task.index');
    }

    public function setStartedAt($value){
        $this->started_at = $value;
        $this->start_time  = \Morilog\Jalali\Jalalian::forge($this->started_at)->format('%A %d %B %Y');
    }

    public function setFinishedAt($value){
        $this->finished_at = $value;
        $this->finish_time  = \Morilog\Jalali\Jalalian::forge($this->finished_at)->format('%A %d %B %Y');
    }
}
