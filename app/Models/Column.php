<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "name",
        "table_id",
        "column_type_id",
        "select_table_id",
    ];

    public function table(){
        return $this->belongsTo(Table::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function columnType(){
        return $this->belongsTo(ColumnType::class);
    }

    public function selectTable(){
        return $this->belongsTo(Table::class,"select_table_id");
    }
}
