<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'started_at',
        'finished_at',
    ];

    public function users(){
        return $this->belongsToMany(User::class,'task_user');
    }

    public function taskStatus(){
        return $this->belongsTo(TaskStatus::class);
    }
}
