<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function assignTeamsToProject()
    {
        return $this->assignedTeamsToProject()->pluck('team_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class,'project_team');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class,'client_project');
    }


    public function settings()
    {
        return $this->hasMany(Settings::class);
    }

    public function assignedTeams()
    {
        return $this->teams()->get();
    }

    public function unassignedTeams()
    {
        $teams = $this->teams()->pluck('team_id');
        $unassignedTeams = Team::whereNotIn('id', $teams)->get();
        return $unassignedTeams;
    }

    public function assignPojectToTeam(Team $team)
    {
        return $this->belongsToMany(Team::class,'team_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function file()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function shortDetails()
    {
        return Str::words(strip_tags($this->details), 20);
    }


}

