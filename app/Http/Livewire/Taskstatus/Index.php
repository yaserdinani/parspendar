<?php

namespace App\Http\Livewire\Taskstatus;

use Livewire\Component;
use App\Models\TaskStatus;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    // public $statuses;
    public $name;
    public $status_id;
    public $update_mode = false;
    public $current_status;
    public $filter_text;

    // protected $listeners = ["statusAdded","statusChanged","statusRemoved"];

    protected $rules = [
        "name"=>["required","string","min:3","max:30"]
    ];

    public function mount(){
        // $this->statuses = TaskStatus::all();
    }

    public function setStatus(TaskStatus $status){
        $this->current_status = $status;
    }

    public function resetInputs(){
        $this->name = null;
        $this->update_mode = false;
        $this->status_id = null;
        $this->current_status = null;
    }

    // public function statusAdded(){
    //     $this->statuses = TaskStatus::all();
    // }

    // public function statusChanged(){
    //     $this->statuses = TaskStatus::all();
    // }

    // public function statusRemoved(){
    //     $this->statuses = TaskStatus::all();
    // }

    public function store(){
        abort_unless(auth()->user()->can('status-create'), '403', 'Unauthorized.');
        $validation = $this->validate();
        TaskStatus::create($validation);
        // $this->emit('statusAdded');
        $this->resetInputs();
    }

    public function edit(TaskStatus $status){
        $this->update_mode = true;
        $this->status_id = $status->id;
        $this->name = $status->name;
        $this->current_status = $status;
    }

    public function update(){
        abort_unless(auth()->user()->can('status-edit'), '403', 'Unauthorized.');
        $validation = $this->validate();

        if($this->status_id){
            $this->current_status->update($validation);
            $this->resetInputs();
            // $this->emit('statusChanged');
        }

    }

    public function delete(){
        abort_unless(auth()->user()->can('status-delete'), '403', 'Unauthorized.');
        $this->current_status->delete();
        $this->resetInputs();
        // $this->emit('statusRemoved');
    }

    public function render()
    {
        abort_unless(auth()->user()->can('status-list'), '403', 'Unauthorized.');
        $statuses = TaskStatus::select("*")
        ->where('name',"LIKE","%".$this->filter_text."%")
        ->paginate(2);
        return view('livewire.taskstatus.index',["statuses"=>$statuses]);
    }
}
