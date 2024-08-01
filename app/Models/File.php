<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function fileable()
    {
        return $this->morphMany();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable($model)
    {
        return $this->morphTo();

    }

}
