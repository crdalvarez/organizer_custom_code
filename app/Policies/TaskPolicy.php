<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;
use App\Models\Team;
use App\Models\Project;

use App\Models\Profile;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        $taskOwner = Task::where('user_id', $user->id)->exists();

        return !empty($taskOwner);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        $taskOwner = $task->user_id == $user->id || $task->responsible_id == $user->id;

        if ($taskOwner) {
            return true;
        }

        // Check if the user is the owner or leader of a team with tasks
        $teams = Team::where('user_id', $user->id)->orWhere('leader_id', $user->id)->get();
        foreach ($teams as $team) {
            $collaboratorIds = $team->collaborators->pluck('id')->toArray();
            $teamTasksExist = Task::whereIn('responsible_id', $collaboratorIds)->exists();

            if ($teamTasksExist) {
                return true;
            }
        }

        // Check if the user is the owner of a project with tasks
        $projects = Project::where('user_id', $user->id)->whereHas('stages.tasks')->get();

        $taskExists = Task::whereHas('stage.project', function ($query) use ($projects) {
            $query->whereIn('id', $projects->pluck('id'));
        })->exists();

        return $taskExists;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $projects = Project::where('user_id', $user->id)->exists();
        if ($projects) {
            return true;
        }

        $projects = Project::where('user_id', $user->id)->get();

        foreach ($projects as $project) {
            foreach ($project->teams as $team) {
                if ($team->user_id === $user->id || $team->leader_id === $user->id) {
                    return true;
                }

                foreach ($team->collaborators as $collaborator) {
                    if ($collaborator === $user->id) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */

    public function edit(User $user, Task $task): bool
    {
        return $user->id == $task->user_id;
    }

    public function update(User $user, Task $task): bool
    {
        
        $taskOwner = $task->user_id == $user->id || $task->responsible_id == $user->id;

        if ($taskOwner && $task->status ==='open') {
            return true;
        }

        // Check if the user is the owner or leader of a team with tasks
        $teams = Team::where('user_id', $user->id)->orWhere('leader_id', $user->id)->get();
        foreach ($teams as $team) {
            $collaboratorIds = $team->collaborators->pluck('id')->toArray();
            $teamTasksExist = Task::whereIn('responsible_id', $collaboratorIds)->exists();

            if ($teamTasksExist && $task->status ==='open') {
                return true;
            }
        }

        // Check if the user is the owner of a project with tasks
        $projects = Project::where('user_id', $user->id)->whereHas('stages.tasks')->get();

        $taskExists = Task::whereHas('stage.project', function ($query) use ($projects) {
            $query->whereIn('id', $projects->pluck('id'));
        })->exists();

        return $taskExists;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        $taskOwner = $task->user_id == $user->id || $task->responsible_id == $user->id;

        if ($taskOwner) {
            return true;
        }

        // Check if the user is the owner or leader of a team with tasks
        $teams = Team::where('user_id', $user->id)->orWhere('leader_id', $user->id)->get();
        foreach ($teams as $team) {
            $collaboratorIds = $team->collaborators->pluck('id')->toArray();
            $teamTasksExist = Task::whereIn('responsible_id', $collaboratorIds)->exists();

            if ($teamTasksExist) {
                return true;
            }
        }

        // Check if the user is the owner of a project with tasks
        $projects = Project::where('user_id', $user->id)->whereHas('stages.tasks')->get();

        $taskExists = Task::whereHas('stage.project', function ($query) use ($projects) {
            $query->whereIn('id', $projects->pluck('id'));
        })->exists();

        return $taskExists;
    }
}
