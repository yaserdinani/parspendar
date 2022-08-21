<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;
use App\Models\Notification;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination,LivewireAlert;

    public $filter_text;
    public $current_notification;


    public function setNotification(Notification $notification){
        $this->current_notification = $notification;
    }

    public function delete(){
        $this->current_notification->delete();
        $this->alert('success', 'نوتیفیکیشن به سطل زباله انتقال یافت');
        $this->emitTo('notification','refreshNotification');
    }

    public function resetInputs(){
        $this->current_notification = null;
    }

    public function render()
    {
        $notifications = auth()->user()->notifications()->where('description',"LIKE","%".$this->filter_text."%")->paginate(5);
        return view('livewire.notification.index',["notifications"=>$notifications]);
    }
}
