<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;


class Index extends Component
{
    use WithPagination;

    public $current_user;
    public $statuses;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;
    public $roles = [];
    public $all_roles;
    protected $listeners = ["updateUserStatus"];

    public function mount(){
        $this->statuses = TaskStatus::all();
        $this->all_roles = Role::all();
    }
    
    public function resetInputs(){
        $this->name = null;
        $this->email = null;
        $this->phone = null;
        $this->password = null;
        $this->password_confirmation = null;
        $this->roles = [];
        $this->current_user = null;
    }

    public function setCurrentUser(User $user){
        $this->current_user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->roles = $user->roles()->get()->pluck('id');
    }

    public function store(){
        abort_unless(auth()->user()->can('user-create'), '403', 'Unauthorized.');
        $validateData = $this->validate(
            [
                "name"=>["required","string","min:3","max:20"],
                "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u","unique:users"],
                "email"=>["required","email","unique:users"],
                "password"=>["required","confirmed"],
                "roles"=>["required","exists:roles,id"]
            ]
        );
        $user = User::create([
            "name"=>$this->name,
            "phone"=>$this->phone,
            "email"=>$this->email,
            "password"=>Hash::make($this->password)
        ]);
        $user->assignRole($this->roles);
        $this->resetInputs();
    }

    public function update(){
        abort_unless(auth()->user()->can('user-edit'), '403', 'Unauthorized.');
        if(isset($this->password)){
            $validateData = $this->validate(
                [
                    "name"=>["required","string","min:3","max:30"],
                    "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u",Rule::unique('users')->ignore($this->current_user->id)],
                    "email"=>["required","email",Rule::unique('users')->ignore($this->current_user->id)],
                    "password"=>["confirmed"],
                    "roles"=>["required","exists:roles,id"]
                ]
            );
            $this->current_user->update([
                "password"=>Hash::make($this->password),
                "name"=>$this->name,
                "phone"=>$this->phone,
                "email"=>$this->email
            ]);
        }
        else{
            $validateData = $this->validate(
                [
                    "name"=>["required","string","min:3","max:30"],
                    "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u",Rule::unique('users')->ignore($this->current_user->id)],
                    "email"=>["required","email",Rule::unique('users')->ignore($this->current_user->id)],
                    "roles"=>["required","exists:roles,id"]
                ]
            );
            $this->current_user->update([
                "name"=>$this->name,
                "phone"=>$this->phone,
                "email"=>$this->email
            ]);
        }
        DB::table('model_has_roles')->where('model_id',$this->current_user->id)->delete();
        $this->current_user->assignRole($this->roles);
        $this->resetInputs();
    }

    public function delete(){
        abort_unless(auth()->user()->can('user-delete'), '403', 'Unauthorized.');
        $this->current_user->delete();
        $this->resetInputs();
    }

    public function updateUserStatus(User $user,$value){
        $user->update([
            "is_active" => ($value==0) ? false : true
        ]);
    }

    public function render()
    {
        abort_unless(auth()->user()->can('user-list'), '403', 'Unauthorized.');
        $users = User::paginate(2);
        return view('livewire.user.index')
        ->with('users', $users);
    }
}
