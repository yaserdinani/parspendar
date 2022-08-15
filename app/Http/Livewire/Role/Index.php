<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class Index extends Component
{
    public $name;
    public $permissions = [];
    public $current_role;
    public $roles;
    protected $listeners = ['roleAdded','roleChanged','roleRemoved'];
    public $all_permissions;

    public function mount(){
        $this->roles = Role::all();
        $this->all_permissions = Permission::all();
    }

    public function roleAdded(){
        $this->roles = Role::all();
    }

    public function roleChanged(){
        $this->roles = Role::all();
    }

    public function roleRemoved(){
        $this->roles = Role::all();
    }

    public function resetInputs(){
        $this->name = null;
        $this->current_role = null;
        $this->permissions = [];
    }

    public function setCurrentRole(Role $role){
        $this->current_role = $role;
        $this->name = $role->name;
        $this->permissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
        ->pluck("permission_id")->all();
    }

    public function store(){
        $validateData = $this->validate([
            "name"=>["required","unique:roles,name"],
            "permissions"=>["required"]
        ]);

        $role = Role::create([
            "name"=>$this->name
        ]);
        $role->syncPermissions($this->permissions);
        $this->resetInputs();
        $this->emit('roleAdded');
    }

    public function update(){
        $validateData = $this->validate([
            "name"=>["required",Rule::unique('roles')->ignore($this->current_role->id)],
            "permissions"=>["required"]
        ]);

        $this->current_role->update([
            "name"=>$this->name
        ]);
        
        $this->current_role->syncPermissions($this->permissions);
        $this->resetInputs();
        $this->emit('roleChanged');
    }

    public function delete(){
        $this->current_role->delete();
        $this->resetInputs();
        $this->emit('roleRemoved');
    }

    public function render()
    {
        return view('livewire.role.index');
    }
}
