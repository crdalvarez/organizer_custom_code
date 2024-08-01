<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function clientProfile()
    {
        return $this->hasOne(ClientProfile::class);
    }

    public function project()
    {
        return $this->belongsToMany(Project::class, 'client_project');
    }


    protected static function boot()
    {
        parent::boot();
        static::created(
            function ($client) {
                $client->clientProfile()->create([
                    'title' => '',
                ]);
            }
        );
    }
}
