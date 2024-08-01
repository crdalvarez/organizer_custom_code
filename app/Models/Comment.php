<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable($model)
    {
        return $this->morphTo();
    }

    public function task_comments($task_id)
    {

        return Comment::where('task_id', '=', $task_id)->orderBy('created_at','DESC')->get();
    }

    public function ObjectComments($object)
    {
        $comments = Comment::where('commentable_type','=', get_class($object))->where('commentable_id','=',$object->id)->orderBy('created_at', 'DESC')->get();
        return $comments;
    }



}
