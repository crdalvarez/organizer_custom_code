<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function connected()
    {
        return $this->belongsToMany(User::class);
    }

    public function timer()
    {
        return $this->hasMany(Timer::class);
    }

    public function responsible()
    {
        return $this->belongsTo(User::class,'responsible_id');
    }
    public function file()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function ToDo()
    {
        return $this->hasMany(ToDo::class);
    }
}
