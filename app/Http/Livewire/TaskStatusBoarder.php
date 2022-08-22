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
        return Task::query()->get()
        ->map(function (Task $task) {
            return [
                'id' => $task->id,
                'title' => $task->name,
                'status' => $task->task_status_id,
            ];
        });
    }
    public function onStatusChanged($recordId, $statusId, $fromOrderedIds, $toOrderedIds)
    {
        Task::find($recordId)->update([
            "task_status_id"=>$statusId
        ]);
        $this->emitUp('taskStatusUpdated');
        $this->alert('success', 'وضعیت تسک تغییر یافت');
    }
    // public function onRecordClick($recordId)
    // {
    //     dd("onRecordClick",$recordId);
    // }
    // public function onStatusSorted($recordId, $statusId, $orderedIds)
    // {
    //     dd("onStatusSorted",$recordId, $statusId, $orderedIds);
    // }
}
