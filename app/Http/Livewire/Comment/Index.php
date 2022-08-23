<?php

namespace App\Http\Livewire\Comment;

use Livewire\Component;
use App\Models\Task;
use App\Models\Comment;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Events\MentionComment;

class Index extends Component
{
    use LivewireAlert;
    
    public $task;
    public $comments;
    public $description;
    public $users;
    public $mention_list = [];
    public $text_mention_list = [];
    public $showUsersFlag = false;

    protected $rules = [
        "description" =>["required","min:3","max:200","string"],
        "mention_list"=>["exists:users,id"]
    ];

    protected $listeners = ["commentAdded","userChoosed"];

    public function mount(Task $task){
        $this->task = $task;
        $this->comments = $task->comments;
        $this->users = User::all();
    }

    public function userChoosed($value){
        dd($value);
    }

    public function resetInputs(){
        $this->description = null;
    }

    public function store(){
        $this->validate();
        $comment = Comment::create([
            "user_id"=>auth()->user()->id,
            "task_id"=>$this->task->id,
            "description"=>$this->description
        ]);
        $comment->mentionUsers()->sync($this->mention_list);
        event(new MentionComment($comment));
        $this->alert('success', 'یادداشت شما با موفقیت ثبت شد');
        $this->resetInputs();
        $this->emit('commentAdded');
    }

    public function commentAdded(){
        $this->comments = $this->task->comments;
    }

    // public function updatedDescription($value){
    //     preg_match_all("/@([\w\-]*)/",$value,$matches);
    //     $this->text_mention_list = $matches[1];
    //     if(count($matches[1])==0){
    //         $this->showUsersFlag = false;
    //     }
    //     else{
    //         $this->showUsersFlag = true;
    //     }
        
    // }

    public function render()
    {
        return view('livewire.comment.index');
    }
}
