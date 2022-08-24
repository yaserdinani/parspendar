<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColumnType extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "name"
    ];

    public function columns(){
        return $this->hasMany(Column::class);
    }
}
