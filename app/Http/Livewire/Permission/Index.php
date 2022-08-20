<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination,LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $name;
    public $current_permission;
    public $filter_text;

    public function store(){
        abort_unless(auth()->user()->can('permission-create'), '403', 'Unauthorized.');
        $validateData = $this->validate([
            "name"=>["required","unique:permissions","string","min:3","max:30"]
        ]);
        Permission::create($validateData);
        $this->resetInputs();
        $this->alert('success', 'دسترسی ایجاد شد');
    }

    public function resetInputs(){
        $this->name = null;
        $this->current_permission = null;
        $this->resetValidation();
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
        $this->alert('success', 'دسترسی ویرایش شد');
    }

    public function delete(){
        abort_unless(auth()->user()->can('permission-delete'), '403', 'Unauthorized.');
        $this->current_permission->delete();
        $this->resetInputs();
        $this->alert('success', 'دسترسی به سطل زباله انتقال یافت');
    }


    public function render()
    {
        abort_unless(auth()->user()->can('permission-list'), '403', 'Unauthorized.');
        $permissions = Permission::select("*")
        ->where("name","LIKE","%".$this->filter_text."%")
        ->paginate(5);
        return view('livewire.permission.index',["permissions"=>$permissions]);
    }
}
