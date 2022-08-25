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
    public $mention_list;
    public $text_mention_list = [];
    public $showUsersFlag = false;
    public $match_text;
    public $counter;

    protected $rules = [
        "description" =>["required","min:3","max:200","string"],
        "mention_list"=>["exists:users,id"]
    ];

    protected $listeners = ["commentAdded","userChoosed"];

    public function mount(Task $task){
        $this->task = $task;
        $this->comments = $task->comments;
        $this->users = User::all();
        $this->counter = 0;
        $this->mention_list = [];
    }

    public function userChoosed(User $user){
        $this->description = chop($this->description,$this->match_text);
        $this->description = $this->description . $user->phone . "\n";
        $this->showUsersFlag = !$this->showUsersFlag;
        $this->mention_list = [$user->id];
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
        preg_match_all("/@([\w\-]+)/",$this->description,$matches);
        $users_list = User::whereIn("phone",$matches[1])->get()->pluck('id');
        $comment->mentionUsers()->sync($users_list);
        event(new MentionComment($comment));
        $this->alert('success', 'یادداشت شما با موفقیت ثبت شد');
        $this->resetInputs();
        $this->emit('commentAdded');
    }

    public function commentAdded(){
        $this->comments = $this->task->comments;
    }

    public function updatedDescription($value){
        preg_match_all("/@([\w\-]+)/",$value,$matches);
        if(count($matches[1])==0 || $this->counter>=count($matches[1])){
            $this->showUsersFlag = false;
            if($this->counter!=0 && $this->counter>count($matches[1])){
                $this->counter = $this->counter-1;
            }
        }
        else{
            $this->mention_users_phone_list = $matches[1];
            if(isset($matches[1][$this->counter])){
                $this->match_text = $matches[1][$this->counter];
                if(count($this->mention_list)!=0){
                    $this->users = User::where("name","LIKE","%".$matches[1][$this->counter]."%")->whereNotIn("phone",$matches[1])->get();
                }
                else{
                    $this->users = User::where("name","LIKE","%".$matches[1][$this->counter]."%")->get();
                }
                $this->showUsersFlag = true;
                $this->counter = $this->counter+1;
            }
            else{
                $this->showUsersFlag = false;
            }
            
        }
    }

    public function render()
    {
        return view('livewire.comment.index');
    }
}
