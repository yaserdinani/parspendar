<?php

namespace App\Http\Livewire\Calender;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Task;

class Index extends Component
{
    public $today;
    public $task;
    public $all_tasks;
    protected $listeners = ["setTask","getTasksOfMonth"];

    public function getTasksOfMonth(){
        if(auth()->user()->can('see-all-tasks')){
            $this->all_tasks = Task::all();
        }
        else{
            $this->all_tasks = auth()->user()->tasks();
        }
    }

    public function setTask(Task $task){
        // dd($task);
        $this->task = $task;
    }

    public function mount(){
        if(auth()->user()->can('see-all-tasks')){
            $this->all_tasks = Task::all();
        }
        else{
            $this->all_tasks = auth()->user()->tasks();
        }
        $this->today = \Morilog\Jalali\Jalalian::forge(Carbon::now())->format('%A %d %B %Y');
    }
    public function render()
    {
        return view('livewire.calender.index');
    }
}
