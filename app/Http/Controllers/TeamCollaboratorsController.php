<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;

class TeamCollaboratorsController extends Controller
{
    public function store(Team $team, User $user)
    {
        $team->collaborators()->toggle($user->id);
        return redirect('/team/'.$team->id);
    }
}
