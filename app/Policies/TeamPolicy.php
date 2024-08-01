<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeamPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $teamUserCreator = [];
        $teamUserLeader = [];
        $teamsUserCollaborate = [];

        //teams where user is the creator or team leader
        $teamUserCreator = Team::where('user_id', $user->id)->pluck('user_id')->toArray();
        $teamUserLeader = Team::where('leader_id', $user->id)->pluck('leader_id')->toArray();

        // teams where user is collaborating
        $teamsUserCollaborate = $user->collaboratingTeams->pluck('id')->toArray();

        $allTeams = array_unique(array_merge($teamUserCreator, $teamUserLeader, $teamsUserCollaborate));

        return !empty($allTeams);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Team $team): bool
    {
        if ($team->user_id === $user->id) {
            return true;
        }

        if ($team->leader_id === $user->id) {
            return true;
        }

        foreach ($team->collaborators as $collaborator) {
            if ($collaborator->id === $user->id) {
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
    public function update(User $user, Team $team): bool
    {
        return (($team->user_id === $user->id) || ($team->leader_id === $user->id));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Team $team): bool
    {
        return $team->user_id === $user->id;
    }

    public function changeLeader(User $user, Team $team): bool
    {
        return false;
    }


    
}
