<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;
use App\Models\Task;

class Index extends Component
{

    public function delete(Task $task){
        $task->delete();
    }

    public function render()
    {
        $tasks = Task::all();
        return view('livewire.task.index',["tasks" => $tasks]);
    }
}
