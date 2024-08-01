<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;


    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class,'team_user');
    }

    public function noCollaborators()
    {
        $collaborators = $this->collaborators()->pluck('user_id');
        $noCollaborators = User::whereNotIn('id', $collaborators)->get();
        return $noCollaborators;
    }

    public function leaders()
    {
        $leaders = User::where('id', $this->leader_id)->orderBy('created_at','DESC')->get();
        return $leaders;
    }

    public function assignTeamToProject(Project $project)
    {
        return $this->belongsToMany(Project::class, 'project_id');
    }

    public function project()
    {
        return $this->belongsToMany(Project::class, 'project_team');
    }

}
