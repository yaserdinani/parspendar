<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class Navbar extends Component
{

    public function logout(){
        auth()->logout();
        return redirect()->route('auth.index');
    }

    public function showNotifications(){
        return redirect()->route('livewire.notifications.index');
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }
}
