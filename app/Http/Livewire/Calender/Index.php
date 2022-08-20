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
    public $filter_text;

    public function setTask(Task $task){
        $this->task = $task;
        $datework = Carbon::createFromDate($task->finished_at);
        $now = Carbon::now();
        if($datework>$now){
            $this->remaining_time = $datework->diffInDays($now);
        }
        else{
            $this->remaining_time = "پایان رسیده";
        }
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

    public function render()
    {
        if($this->filter_type!=0){
            if(auth()->user()->can('see-all-tasks')){
                $this->all_tasks = Task::where("task_status_id",$this->filter_type)
                ->where("name","LIKE","%".$this->filter_text."%")
                ->where("description","LIKE","%".$this->filter_text."%")
                ->get();
            }
            else{
                $this->all_tasks = auth()->user()->tasks()->where("name","LIKE","%".$this->filter_text."%")
                ->orWhere("description","LIKE","%".$this->filter_text."%")
                ->get();;
            } 
        }
        else{
            if(auth()->user()->can('see-all-tasks')){
                $this->all_tasks = Task::orWhere("name","LIKE","%".$this->filter_text."%")
                ->orWhere("description","LIKE","%".$this->filter_text."%")
                ->get();
            }
            else{
                $this->all_tasks = auth()->user()->tasks()->orWhere("name","LIKE","%".$this->filter_text."%")
                ->orWhere("description","LIKE","%".$this->filter_text."%")
                ->get();;
            }
        }
        return view('livewire.calender.index');
    }
}
