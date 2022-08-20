<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination,LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $permissions = [];
    public $current_role;
    public $all_permissions;
    public $filter_text;

    public function mount(){
        $this->all_permissions = Permission::all();
    }

    public function resetInputs(){
        $this->name = null;
        $this->current_role = null;
        $this->permissions = [];
        $this->resetValidation();
    }

    public function setCurrentRole(Role $role){
        $this->current_role = $role;
        $this->name = $role->name;
        $this->permissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
        ->pluck("permission_id")->all();
    }

    public function store(){
        abort_unless(auth()->user()->can('role-create'), '403', 'Unauthorized.');
        $validateData = $this->validate([
            "name"=>["required","unique:roles,name"],
            "permissions"=>["required"]
        ]);

        $role = Role::create([
            "name"=>$this->name
        ]);
        $role->syncPermissions($this->permissions);
        $this->resetInputs();
        $this->alert('success', 'نقش جدید ایجاد شد');
    }

    public function update(){
        abort_unless(auth()->user()->can('role-edit'), '403', 'Unauthorized.');
        $validateData = $this->validate([
            "name"=>["required",Rule::unique('roles')->ignore($this->current_role->id)],
            "permissions"=>["required"]
        ]);

        $this->current_role->update([
            "name"=>$this->name
        ]);
        
        $this->current_role->syncPermissions($this->permissions);
        $this->alert('success', 'نقش ویرایش شد');
    }

    public function delete(){
        abort_unless(auth()->user()->can('role-delete'), '403', 'Unauthorized.');
        $this->current_role->delete();
        $this->resetInputs();
        $this->alert('success', 'نقش به سطل زباله انتقال یافت');
    }

    public function render()
    {
        abort_unless(auth()->user()->can('role-list'), '403', 'Unauthorized.');
        $roles = Role::select("*")
        ->where('name',"LIKE","%".$this->filter_text."%")
        ->paginate(5);
        return view('livewire.role.index',["roles"=>$roles]);
    }
}
