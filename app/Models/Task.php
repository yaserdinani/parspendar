<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'task_status_id',
        'started_at',
        'finished_at',
    ];

    public function users(){
        return $this->belongsToMany(User::class,'task_user');
    }

    public function taskStatus(){
        return $this->belongsTo(TaskStatus::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
