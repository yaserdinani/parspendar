<?php

namespace App\Http\Livewire\Calender;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\TaskStatus;

class Index extends Component
{
    public $today;
    public $task;
    public $all_tasks;
    protected $listeners = ["setTask"];
    public $task_flag;
    public $remaining_time;
    public $filter_type;
    public $statuses;

    public function setTask(Task $task){
        $this->task = $task;
        $datework = Carbon::createFromDate($task->finished_at);
        $now = Carbon::now();
        $this->remaining_time = $datework->diffInDays($now);
        $this->task_flag = true;
    }

    public function mount(){
        if(auth()->user()->can('see-all-tasks')){
            $this->all_tasks = Task::all();
        }
        else{
            $this->all_tasks = auth()->user()->tasks();
        }
        $this->today = \Morilog\Jalali\Jalalian::forge(Carbon::now())->format('%A %d %B %Y');
        $this->statuses = TaskStatus::all();
        $this->task_flag = false;
        $this->task = null;
    }

    public function filterTasks($filter_type=0){
        $this->filter_type = $filter_type;
        if($this->filter_type!=0){
            if(auth()->user()->can('see-all-tasks')){
                $this->all_tasks = Task::where("task_status_id",$filter_type)->get();
            }
            else{
                $this->all_tasks = auth()->user()->tasks();
            }
        }
        else{
            if(auth()->user()->can('see-all-tasks')){
                $this->all_tasks = Task::all();
            }
            else{
                $this->all_tasks = auth()->user()->tasks();
            }
        }
    }

    public function render()
    {
        return view('livewire.calender.index');
    }
}
