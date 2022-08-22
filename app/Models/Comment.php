<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "comment_id",
        "task_id",
        "description"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function parent(){
        return $this->belongsTo(Comment::class,'comment_id')->where('comment_id',0);
    }

    public function childrens(){
        return $this->hasMany(Comment::class,'comment_id');
    }

    public function mentionUsers(){
        return $this->belongsToMany(User::class,'comment_user');
    }
}
