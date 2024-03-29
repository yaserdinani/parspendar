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
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;


class Index extends Component
{
    use WithPagination,LivewireAlert;

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
    public $filter_text;
    public $filter_type;

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
        $this->resetValidation();
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
        Mail::to($user)->send(new WelcomeMail($user,$this->password));
        $this->resetInputs();
        $this->alert('success', 'کاربر جدید ایجاد شد');
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
        // $this->resetInputs();
        $this->alert('success', 'اطلاعات کاربر ویرایش شد');
    }

    public function delete(){
        abort_unless(auth()->user()->can('user-delete'), '403', 'Unauthorized.');
        $this->current_user->delete();
        $this->resetInputs();
        $this->alert('success', 'کاربر به سطل زباله انتقال یافت');
    }

    public function updateUserStatus(User $user,$value){
        abort_unless(auth()->user()->can('change-user-status'), '403', 'Unauthorized.');
        $user->update([
            "is_active" => ($value==0) ? false : true
        ]);
        $this->alert('success', 'وضعیت کاربر تغییر کرد');
    }

    public function render()
    {
        abort_unless(auth()->user()->can('user-list'), '403', 'Unauthorized.');
        if(isset($this->filter_type) && $this->filter_type!=2){
            $users = User::select("*")
            ->where("is_active","=",($this->filter_type==0) ? false : true)
            ->paginate(2);
        }
        else{
            $users = User::select("*")
            ->where("name","LIKE","%".$this->filter_text."%")
            ->orWhere("phone","LIKE","%".$this->filter_text."%")
            ->orWhere("email","LIKE","%".$this->filter_text."%")
            ->paginate(2);
        }
        return view('livewire.user.index')
        ->with('users', $users);
    }
}
