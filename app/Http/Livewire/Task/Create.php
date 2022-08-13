<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;
use App\Models\Task;
use App\Models\User;

class Create extends Component
{

    public $name;
    public $started_at;
    public $finished_at;
    public $status;
    public $persons=[];
    public $description;

    protected $rules = [
        "name"=>["required", "min:3","max:30"],
        "status"=>["required", "in:0,1,2"],
        "started_at"=>["required", "date","after:yesterday","before:finished_at"],
        "finished_at"=>["required", "date","after:started_at"],
    ];

    public function store() {

        $this->validate();

        if(count($this->persons)>0){
            $task = Task::create([
                "name"=>$this->name,
                "description"=>$this->description,
                "status"=>$this->status,
                "started_at"=>$this->started_at,
                "finished_at"=>$this->finished_at
            ]);
            $users = User::find($this->persons);
            $task->users()->attach($users);
            return redirect()->route('livewire.tasks.index');
        }
        else{
            $task = Task::create([
                "name"=>$this->name,
                "description"=>$this->description,
                "status"=>$this->status,
                "started_at"=>$this->started_at,
                "finished_at"=>$this->finished_at
            ]);
            $task->users()->attach(auth()->user());
            return redirect()->route('livewire.tasks.index');
        }
    }

    public function render()
    {
        $users = User::all();
        return view('livewire.task.create',["users"=>$users]);
    }
}
