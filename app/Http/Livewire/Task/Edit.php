<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{

    public $task;
    public $name;
    public $persons = [];
    public $status;
    public $description;
    public $finished_at;
    public $started_at;

    protected $rules = [
        "name"=>["required", "min:3","max:30"],
        "status"=>["required", "in:0,1,2"],
        "started_at"=>["required", "date","after:yesterday","before:finished_at"],
        "finished_at"=>["required", "date","after:started_at"],
    ];

    public function mount(Task $task){
        $this->task = $task;
        $this->name = $task->name;
        $this->status = $task->status;
        $this->description = $task->description;
        $this->persons = $task->users()->get()->pluck('id');
        $this->finished_at = date('Y-m-d', strtotime($task->finished_at));
        $this->started_at = date('Y-m-d', strtotime($task->started_at));
    }

    public function update(){
        $this->validate();
        if(count($this->persons)>0){
            $this->task->update([
                "name"=>$this->name,
                "description"=>$this->description,
                "status"=>$this->status,
                "started_at"=>$this->started_at,
                "finished_at"=>$this->finished_at
            ]);
            $this->task->users()->detach($this->task->users()->get());
            $this->task->users()->attach(User::find($this->persons));
            return redirect()->route('livewire.tasks.index');

        }
        else{
            $this->task->update([
                "name"=>$this->name,
                "description"=>$this->description,
                "status"=>$this->status,
                "started_at"=>$this->started_at,
                "finished_at"=>$this->finished_at
            ]);
            return redirect()->route('livewire.tasks.index');
        }

    }

    public function render()
    {
        $users = User::all();
        return view('livewire.task.edit',["users"=>$users]);
    }
}
