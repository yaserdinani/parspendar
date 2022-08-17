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
        $this->emitUp('getTasksOfMonth');
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
                ];
            });

    }
    public function onDayClick($year, $month, $day)
    {
        dd($year, $month, $day);
    }
    public function onEventClick($eventId)
    {
        // dd($eventId);
        $this->emitUp('setTask',$eventId);
    }
}
