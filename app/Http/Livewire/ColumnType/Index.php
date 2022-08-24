<?php

namespace App\Http\Livewire\ColumnType;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\ColumnType;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination,LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    public $filter_text;
    public $name;
    public $current_column_type;

    public function mount(){
        $this->filter_text = "";
        $this->name = "";
        $this->current_column_type = "";
    }

    public function setCurrentTable(ColumnType $columnType){
        $this->current_column_type = $columnType;
        $this->name = $columnType->name;
    }

    public function resetInputs(){
        $this->reset();
    }

    public function store(){
        abort_unless(auth()->user()->can('column-type-create'), '403', 'Unauthorized.');
        $validateData = $this->validate([
            "name"=>["required","unique:tables","string","min:3","max:30"]
        ]);

        ColumnType::create($validateData);
        $this->alert('success', 'نوع ستون با موفقیت ایجاد شد');
        $this->resetInputs();
    }

    public function update(){
        abort_unless(auth()->user()->can('column-type-update'), '403', 'Unauthorized.');
        $validateData = $this->validate([
            "name"=>["required",Rule::unique('column_types')->ignore($this->current_column_type->id),"string","min:3","max:30"]
        ]);

        $this->current_column_type->update($validateData);
        $this->alert('success', 'نوع ستون با موفقیت ویرایش شد');
        $this->resetInputs();

    }

    public function delete(){
        abort_unless(auth()->user()->can('column-type-delete'), '403', 'Unauthorized.');
        $this->current_column_type->delete();
        $this->alert('success', 'نوع ستون با موفقیت حذف گردید');
        $this->resetInputs();
    }
    
    public function render()
    {
        abort_unless(auth()->user()->can('column-types-list'), '403', 'Unauthorized.');
        $columnTypes = ColumnType::where("name","LIKE","%".$this->filter_text."%")->paginate(5);
        return view('livewire.column-type.index',["columnTypes"=>$columnTypes]);
    }
}
