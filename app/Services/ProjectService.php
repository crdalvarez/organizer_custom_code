<?php
namespace App\Http\Controllers;
namespace App\Services;

use App\Models\Project;
use App\Models\Settings;



class ProjectService
{
    public function createProjectWithSettings($projectData)
    {
        $project = auth()->user()->projects()->create($projectData);
        $this->createProjectSettings($project);
        return $project;
    }

    protected function createProjectSettings(Project $project)
    {
        $commonProperties = [
            'user_id' => auth()->user()->id,
            'model' => get_class($project),
            'element_id' => $project->id,
            'setting' => 'task-status',
            'order' => 0,
            'status' => 1,
            'group' => 'settings',
            'policy' => 'true',
        ];

        $settingsStatusOpen = (new Settings)->fill(array_merge($commonProperties, ['value' => 'open']))->save();
        $settingsStatusClosed = (new Settings)->fill(array_merge($commonProperties, ['value' => 'closed']))->save();
    }
}
