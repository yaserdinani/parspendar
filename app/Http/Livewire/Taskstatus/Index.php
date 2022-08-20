<?php

namespace App\Http\Livewire\Taskstatus;

use Livewire\Component;
use App\Models\TaskStatus;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination,LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    public $name;
    public $status_id;
    public $update_mode = false;
    public $current_status;
    public $filter_text;
    public $color;

    protected $listeners =["changeStatusColor"];

    protected $rules = [
        "name"=>["required","string","min:3","max:30"],
        "color"=>["required"]
    ];

    public function setStatus(TaskStatus $status){
        $this->current_status = $status;
    }

    public function changeStatusColor(TaskStatus $status,$value){
        abort_unless(auth()->user()->can('status-edit'), '403', 'Unauthorized.');
        $status->update([
            "color"=>$value
        ]);
        $this->alert('success', 'رنگ وضعیت ویرایش شد');
    }

    public function resetInputs(){
        $this->name = null;
        $this->update_mode = false;
        $this->status_id = null;
        $this->current_status = null;
        $this->color= null;
        $this->resetValidation();
    }

    public function store(){
        abort_unless(auth()->user()->can('status-create'), '403', 'Unauthorized.');
        $validation = $this->validate();
        TaskStatus::create($validation);
        $this->resetInputs();
        $this->alert('success', 'وضعیت جدید ایجاد شد');
    }

    public function edit(TaskStatus $status){
        $this->update_mode = true;
        $this->status_id = $status->id;
        $this->name = $status->name;
        $this->current_status = $status;
        $this->color = $status->color;
    }

    public function update(){
        abort_unless(auth()->user()->can('status-edit'), '403', 'Unauthorized.');
        $validation = $this->validate();

        if($this->status_id){
            $this->current_status->update($validation);
            $this->alert('success', 'وضعیت ویرایش شد');
        }

    }

    public function delete(){
        abort_unless(auth()->user()->can('status-delete'), '403', 'Unauthorized.');
        $this->current_status->delete();
        $this->resetInputs();
        $this->alert('success', 'وضعیت به سطل زباله انتقال یافت');
    }

    public function render()
    {
        abort_unless(auth()->user()->can('status-list'), '403', 'Unauthorized.');
        $statuses = TaskStatus::select("*")
        ->where('name',"LIKE","%".$this->filter_text."%")
        ->paginate(5);
        return view('livewire.taskstatus.index',["statuses"=>$statuses]);
    }
}
