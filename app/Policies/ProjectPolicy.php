<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use App\Models\Team;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $userProjects = [];
        $teamUserCreator = [];
        $teamProjects = [];

        // Get projects where user is the creator. Get user team creator, team leader or team collaborator
        $userProjects = Project::where('user_id', $user->id)->pluck('id')->toArray();
        $teamUserCreator = Team::where('user_id', $user->id)->pluck('user_id')->toArray();
        $teamUserLeader = Team::where('leader_id', $user->id)->pluck('leader_id')->toArray();

        // Get projects where user is collaborator
        $teamsUserCollaborator = $user->collaboratingTeams->pluck('id')->toArray();
            foreach($teamsUserCollaborator as $team)
            {
                $teamProjects = Project::whereHas('teams', function ($query) use ($teamsUserCollaborator) {
                    $query->whereIn('teams.id', $teamsUserCollaborator);
                })->pluck('id')->toArray();
              
            }

        $allProjects = array_unique(array_merge($teamProjects, $userProjects, $teamUserCreator, $teamUserLeader));

        return !empty($allProjects);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        $userId = $user->id;

        // If user created the project
        if ($project->user_id === $userId){

            return true;
        }

        $projectTeams = $project->assignedTeams();

            // If user is creator or leader of any of those teams
            foreach($projectTeams as $team)
            {
                if(($team->user_id === $userId) || ($team->leader_id === $userId)){
                    return true;
                }

                // If user is a team collaborator
                if ($team->collaborators()->where('users.id', $userId)->exists()) {
                    return true;
                }
            }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project)
    {
        return ((
                    ($project->user_id === $user->id) || 
                    ($project->teams->contains('leader_id', auth()->user()->id) !== null)
                ) && 
                $project->status === 'open');
    }

    
    public function open(User $user, Project $project)
    {
        return (
                    ($project->user_id === $user->id) || 
                    ($project->teams->contains('leader_id', auth()->user()->id) !== null)
                );
    }

    public function collaborate(User $user, Project $project)
    {
        $userId = $user->id;

            return (
                (($project->teams->contains('user_id', $userId) !== null) || 
                ($project->teams->conatains('leader_id', $userId) !== null) || 
                $project->teams->collaborators->contains('id', $userId) ||
                ($project->user_id === $userId)) &&
                ($project->status !== 'closed')
            );
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
          return $project->user_id === $user->id; 
    }

}
