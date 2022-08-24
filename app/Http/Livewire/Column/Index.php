<?php

namespace App\Http\Livewire\Column;

use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\ColumnType;
use App\Models\Column;
use App\Models\Table;

class Index extends Component
{
    use WithPagination,LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    public $name;
    public $table_id;
    public $column_type_id;
    public $select_table_id;
    public $current_column;
    public $tables;
    public $column_types;
    public $filter_text;

    protected $rules = [
        "table_id" => ["required","exists:tables,id"],
        "name" => ["required","min:3","max:30","string"],
        "column_type_id" => ["required","exists:column_types,id"],
    ];

    public function mount(){
        $this->name = null;
        $this->table_id = null;
        $this->column_type_id = null;
        $this->select_table_id = null;
        $this->current_column = null;
        $this->tables = Table::all();
        $this->column_types = ColumnType::all();
        $this->filter_text = null;
    }

    public function resetInputs(){
        $this->reset();
    }

    public function setCurrentColumn(Column $column){
        $this->current_column = $column;
        $this->table_id = $column->table_id;
        $this->name = $column->name;
        $this->column_type_id = $column->column_type_id;
        $this->select_table_id = $column->select_table_id;
    }

    public function store(){
        abort_unless(auth()->user()->can('column-create'), '403', 'Unauthorized.');
        $validateData = $this->validate();
        Column::create($validateData);
        $this->alert('success', 'ستون با موفقیت ایجاد شد');
        $this->resetInputs();
    }

    public function update(){
        abort_unless(auth()->user()->can('column-update'), '403', 'Unauthorized.');
        $validateData = $this->validate();
        $this->current_column->update($validateData);
        $this->alert('success', 'ستون با موفقیت ویرایش شد');
        $this->resetInputs();
    }

    public function delete(){
        abort_unless(auth()->user()->can('column-delete'), '403', 'Unauthorized.');
        $this->current_column->delete();
        $this->alert('success', 'ستون با موفقیت حذف شد');
        $this->resetInputs();
    }

    public function render()
    {
        abort_unless(auth()->user()->can('column-list'), '403', 'Unauthorized.');
        $columns = Column::where("name","LIKE","%".$this->filter_text."%")->paginate(5);
        return view('livewire.column.index',["columns"=>$columns]);
    }
}
