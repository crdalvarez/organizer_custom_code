<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;

class ClientProjectController extends Controller
{
    public function store(Client $client, Project $project)
    {
        $client = Client::find(request()->client);
        $project = Project::find(request()->project);

        if (!$project || !$client) {
            abort(404);
        }

        $project->clients()->toggle($client);

        return redirect('/project/' . $project->id . '/edit');
    }
}
