<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Table;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination,LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    public $filter_text;
    public $name;
    public $current_table;

    public function mount(){
        $this->filter_text = "";
        $this->name = "";
        $this->current_table = "";
    }

    public function setCurrentTable(Table $table){
        $this->current_table = $table;
        $this->name = $table->name;
    }

    public function resetInputs(){
        $this->reset();
    }

    public function store(){
        abort_unless(auth()->user()->can('table-create'), '403', 'Unauthorized.');
        $validateData = $this->validate([
            "name"=>["required","unique:tables","string","min:3","max:30"]
        ]);

        Table::create($validateData);
        $this->alert('success', 'جدول با موفقیت ایجاد شد');
        $this->resetInputs();
    }

    public function update(){
        abort_unless(auth()->user()->can('table-update'), '403', 'Unauthorized.');
        $validateData = $this->validate([
            "name"=>["required",Rule::unique('tables')->ignore($this->current_table->id),"string","min:3","max:30"]
        ]);

        $this->current_table->update($validateData);
        $this->alert('success', 'جدول با موفقیت ویرایش شد');
        $this->resetInputs();

    }

    public function delete(){
        abort_unless(auth()->user()->can('table-delete'), '403', 'Unauthorized.');
        $this->current_table->delete();
        $this->alert('success', 'جدول با موفقیت حذف گردید');
        $this->resetInputs();
    }
    
    public function render()
    {
        abort_unless(auth()->user()->can('table-list'), '403', 'Unauthorized.');
        $tables = Table::where("name","LIKE","%".$this->filter_text."%")->paginate(5);
        return view('livewire.table.index',["tables"=>$tables]);
    }
}
