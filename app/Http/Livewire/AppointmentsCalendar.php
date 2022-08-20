<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Models\Task;

class AppointmentsCalendar extends LivewireCalendar
{
    public function events() : Collection
    {
        return Task::query()
            ->whereDate('started_at', '>=', $this->gridStartsAt)
            ->whereDate('started_at', '<=', $this->gridEndsAt)
            ->get()
            ->map(function (Task $model) {
                return [
                    'id' => $model->id,
                    'title' => $model->name,
                    'description' => $model->description,
                    'date' => $model->started_at,
                    'color' => $model->taskStatus->color,
                    'finished_at' =>$model->finished_at,
                ];
            });

    }
    public function onEventClick($eventId)
    {
        $this->emitUp('setTask',$eventId);
    }
}
