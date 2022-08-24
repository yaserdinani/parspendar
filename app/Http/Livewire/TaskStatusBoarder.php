<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TaskStatus;
use App\Models\Task;
use Asantibanez\LivewireStatusBoard\LivewireStatusBoard;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TaskStatusBoarder extends LivewireStatusBoard
{
    use LivewireAlert;
    public function statuses() : Collection 
    {
        return TaskStatus::query()->get()
        ->map(function (TaskStatus $taskStatus) {
            return [
                'id' => $taskStatus->id,
                'title' => $taskStatus->name,
            ];
        });
    }

    public function records() : Collection 
    {
        if(auth()->user()->can('see-all-tasks')){
            return Task::query()->orderBy('position')->get()
            ->map(function (Task $task) {
                return [
                    'id' => $task->id,
                    'title' => $task->name,
                    'status' => $task->task_status_id,
                ];
            });
        }
        else{
            return auth()->user()->tasks()->orderBy('position')->get()
            ->map(function (Task $task) {
                return [
                    'id' => $task->id,
                    'title' => $task->name,
                    'status' => $task->task_status_id,
                ];
            });
        }
    }
    public function onStatusChanged($recordId, $statusId, $fromOrderedIds, $toOrderedIds)
    {
        abort_unless(auth()->user()->can('change-task-status'), '403', 'Unauthorized.');
        Task::find($recordId)->update([
            "task_status_id"=>$statusId
        ]);
        foreach($toOrderedIds as $key => $value){
            Task::find($value)->update([
                "position"=>$key+1
            ]);
        }
        $this->emitUp('taskStatusUpdated');
        $this->alert('success', 'وضعیت تسک تغییر یافت');
    }
    public function onStatusSorted($recordId, $statusId, $orderedIds)
    {
        abort_unless(auth()->user()->can('change-task-position'), '403', 'Unauthorized.');
        foreach ($orderedIds as $key => $value){
            Task::find($value)->update([
                "position" => $key+1,
            ]);
        }
        $this->emitUp('taskStatusUpdated');
        $this->alert('success', 'اولویت تسک تغییر یافت');
    }
}
