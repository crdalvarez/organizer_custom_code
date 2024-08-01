<?php

namespace App\Http\Controllers;



use App\Services\ProjectHandler;

use App\Models\Project;
use App\Models\Team;

use Illuminate\Http\Request;

class ProjectTeamsController extends Controller
{
    public function store()
    {
        $team = Team::find(request()->team);
        $project = Project::find(request()->project);
        $this->authorize('update', $project);

        $project->teams()->toggle($team);

        return redirect('/project/'. $project->id.'/edit');
    }

}
