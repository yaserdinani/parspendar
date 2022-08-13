<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{

    public $name;
    public $phone;
    public $role=0;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        "name"=>["required", "min:3","max:30"],
        "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u","unique:users"],
        "email"=>["required","email","unique:users"],
        "password"=>["required","confirmed"],
        "role"=>["required","in:0,1"]
    ];

    public function store(){
        $this->validate();

        User::create([
            "name"=>$this->name,
            "phone"=>$this->phone,
            "email"=>$this->email,
            "password"=>Hash::make($this->password),
            "is_admin"=>($this->role == 0) ? false : true
        ]);

        return redirect()->route('livewire.users.index');
    }

    public function render()
    {
        return view('livewire.user.create');
    }
}
