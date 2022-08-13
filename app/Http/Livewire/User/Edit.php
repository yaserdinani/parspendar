<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public $user;
    public $name;
    public $role;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;

    public function mount(User $user){
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = ($user->is_admin) ? 1 : 0;
    }

    protected function rules(){
        return [
            "name"=>["required", "min:3","max:30"],
            "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u",Rule::unique('users')->ignore($this->user->id)],
            "email"=>["required","email",Rule::unique('users')->ignore($this->user->id)],
            "password"=>["confirmed"],
            "role"=>["required","in:0,1"]
        ];
    }

    public function update(){
        $this->validate();

        $this->user->update([
            "name"=>$this->name,
            "email"=>$this->email,
            "phone"=>$this->phone,
            "password"=>(isset($this->password) ? Hash::make($this->password) : $this->user->password),
            "is_admin"=>($this->role == 0) ? false : true
        ]);

        return redirect()->route('livewire.users.index');
    }

    public function render()
    {
        return view('livewire.user.edit');
    }
}
