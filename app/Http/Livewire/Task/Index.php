<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;

class Index extends Component
{

    public $tasks;
    public $current_task;
    public $name;
    public $description;
    public $users = [];
    public $started_at;
    public $finished_at;
    public $status_id;
    public $statuses;
    public $all_users;

    protected $listeners = ["taskAdded","taskChanged","taskRemoved"];

    public function resetInputs(){
        $this->current_task = null;
        $this->name = null;
        $this->description = null;
        $this->users = [];
        $this->started_at = null;
        $this->finished_at = null;
        $this->status_id = null;
    }

    public function mount(){
        $this->tasks = Task::all();
        $this->all_users = User::all();
        $this->statuses = TaskStatus::all();
    }

    public function taskAdded(){
        $this->tasks = Task::all();
    }

    public function taskRemoved(){
        $this->tasks = Task::all();
    }

    public function taskChanged(){
        $this->tasks = Task::all();
    }
    
    public function setCurrentTask(Task $task){
        $this->currentTask = $task;

    }

    public function delete(){
        abort_unless(auth()->user()->can('task-delete'), '403', 'Unauthorized.');
        $this->currentTask->delete();
        $this->resetInputs();
        $this->emit('taskRemoved');
    }

    public function render()
    {
        abort_unless(auth()->user()->can('task-list'), '403', 'Unauthorized.');
        return view('livewire.task.index');
    }
}
