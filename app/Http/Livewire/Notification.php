<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class Notification extends Component
{
    public $notification_count;

    protected $listeners=["refreshNotification"];

    public function mount(){
        $this->notification_count = auth()->user()->notifications()->where('is_seen',false)->count();
    }

    public function refreshNotification(){
        $this->notification_count = auth()->user()->notifications()->where('is_seen',false)->count();
    }

    public function render()
    {
        return view('livewire.notification');
    }
}
