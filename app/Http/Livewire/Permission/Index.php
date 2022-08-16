<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class Index extends Component
{
    public $name;
    public $current_permission;
    public $permissions;

    protected $listeners = ['permissionAdded','permissionChanged','permissionRemoved'];

    public function mount(){
        $this->permissions = Permission::all();
    }

    public function store(){
        abort_unless(auth()->user()->can('permission-create'), '403', 'Unauthorized.');
        $validateData = $this->validate([
            "name"=>["required","unique:permissions","string","min:3","max:30"]
        ]);
        Permission::create($validateData);
        $this->resetInputs();
        $this->emit('permissionAdded');
    }

    public function permissionAdded(){
        $this->permissions = Permission::all();
    }

    public function permissionChanged(){
        $this->permissions = Permission::all();
    }

    public function permissionRemoved(){
        $this->permissions = Permission::all();
    }

    public function resetInputs(){
        $this->name = null;
        $this->current_permission = null;
    }

    public function setCurrentPermission(Permission $permission){
        $this->current_permission = $permission;
        $this->name = $permission->name;
    }

    public function update(){
        abort_unless(auth()->user()->can('permission-update'), '403', 'Unauthorized.');
        $validateData = $this->validate([
            "name"=>["required",Rule::unique('permissions')->ignore($this->current_permission->id),"string","min:3","max:30"]
        ]);
        $this->current_permission->update($validateData);
        $this->resetInputs();
        $this->emit('permissionChanged');
    }

    public function delete(){
        abort_unless(auth()->user()->can('permission-delete'), '403', 'Unauthorized.');
        $this->current_permission->delete();
        $this->resetInputs();
        $this->emit('permissionRemoved');
    }


    public function render()
    {
        abort_unless(auth()->user()->can('permission-list'), '403', 'Unauthorized.');
        return view('livewire.permission.index');
    }
}
