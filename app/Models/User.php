<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'lastname', 'username', 'email', 'password'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //-----------------------ADMIN LTE
    public function adminlte_image()
    {
        if ($this->image) {
            return Storage::url('profiles/' . $this->image);
        }
        return Storage::url('profiles/no_image.png'); 
    }

    public function adminlte_desc()
    {
        return 'admin';
    }

    public function adminlte_profile_url()
    {
        return 'profile/username';
    }

    //-----------------------------------------------------------------

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function settings()
    {
        return $this->hasMany(Settings::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function collaboratingTeams()
    {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function username($id)
    {
        $data = User::find($id);
        return $data->name;
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($user) {
            $user->profile()->create([
                'title' => $user->username,
            ]);
        });
    }

    public function connecting()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function enroling(Team $team)
    {
        return $this->belongsToMany(Team::class);
    }

    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function todo()
    {
        return $this->hasMany(ToDo::class);
    }

    public function timer()
    {
        return $this->hasMany(Timer::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
