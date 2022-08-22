<?php

namespace App\Http\Livewire\Comment;

use Livewire\Component;
use App\Models\Task;
use App\Models\Comment;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;
    
    public $task;
    public $comments;
    public $description;

    protected $rules = [
        "description" =>["required","min:3","max:200","string"]
    ];

    protected $listeners = ["commentAdded"];

    public function mount(Task $task){
        $this->task = $task;
        $this->comments = $task->comments;
    }

    public function resetInputs(){
        $this->description = null;
    }

    public function store(){
        $this->validate();
        Comment::create([
            "user_id"=>auth()->user()->id,
            "task_id"=>$this->task->id,
            "description"=>$this->description
        ]);
        $this->alert('success', 'یادداشت شما با موفقیت ثبت شد');
        $this->resetInputs();
        $this->emit('commentAdded');
    }

    public function commentAdded(){
        $this->comments = $this->task->comments;
    }

    public function render()
    {
        return view('livewire.comment.index');
    }
}
