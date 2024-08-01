<?php

namespace App\Http\Controllers;

use \stdClass;
use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Models\Project;
use App\Models\User;
use App\Models\Stage;
use App\Models\Task;
use App\Models\Team;
use App\Models\Settings;
use App\Models\Client;


class ProjectsController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }


    public function index(Project $projects, User $user)
    {
        $this->authorize('viewAny', Project::class);

        $user_id = auth()->user()->id;
        $projects = Project::where('user_id', '=', $user_id)->get();
        $allStatus = [];
        if($projects){
            foreach ($projects as $project)
                {
                    $allStatus[] = $project->status;
                }
        }
        $statusGraphValues = array_count_values($allStatus) ?? [];
 
        return view('projects/index', compact('projects', 'statusGraphValues'));
    }


    public function new()
    {
        $this->authorize('create', Project::class);
        return view('projects/new');
    }


    public function create()
    {

        $this->authorize('create', Project::class);

        $data = request()->validate([
            'name' => ['required'],
            'description' => ['required'],
            'details' => ['required'],
            'finish_date' => ['required', 'date'],
            'progress' => [],
            'status' => ['required'],
        ]);

        $project = $this->projectService->createProjectWithSettings($data);

        return redirect('/project/' . $project->id);
    }


    public function show(Project $project, Stage $stages, Task $task)
    {
        $this->authorize('view', $project);

        $event = [];
        $stages = Stage::where('project_id', $project->id)->orderBy('order', 'DESC')->get();
        $allStatus = [];
        foreach ($stages as $stage) {
            $stage->tasks = Task::where('stage_id', $stage->id)->orderBy('order', 'DESC')->paginate(100);
            foreach ($stage->tasks as $events) {
                $event[] = [
                    'id' => $events->id,
                    'title' => $events->name,
                    'start' => $events->start_date,
                    'end' => $events->finish_date,
                    'backgroundColor' => 'light-blue',
                    'border' => 'blue',
                    'editable' => true,
                    'textColor' => '#fff',
                ];
                $allStatus[] = $events->status;
            }
        }

        $data = new stdClass();
        $data->module = $project;
        $data->event = $event;
        $data->commentableType = Project::class;
        $data->comments = $project->comments;
        $data->statusGraphValues = array_count_values($allStatus) ?? [];
        $settings = new SettingsController;
        $data->status = $settings->get(get_class($data->module), $data->module->id, 'settings', 'task-status-color');
        $data->allStatus = $settings->get(get_class($data->module),$data->module->id, 'settings', 'task-status');
        $data->taskStatusProgress = 0;

        $collaborating = collect([$data->module->user]);
        if ($data->module->teams->isNotEmpty()) {
            foreach ($data->module->teams as $team) {
                if ($team->collaborators->isNotEmpty()) {
                    $collaborating =
                        $collaborating->merge([$team->leader])->merge($team->collaborators)->unique('id');
                } else {
                    $collaborating = $collaborating->merge([$team->leader])->unique('id');
                }
            }
        }
        $data->collaborating = $collaborating;

        return view('projects/show', ['data' => $data]);
    }

    /*
    public function show_stage(Project $project, Stage $stage, $show_stage)
    {
        $this->authorize('view', $project);

        $stages = Stage::where('project_id', $project->id)->orderBy('order', 'DESC')->get();
        $stages->tasks = Task::where('stage_id', $stage->id)->orderBy('created_at', 'DESC')->get();

        return view('/projects/show', compact('project', 'stages', 'show_stage'));
    }
    */

    public function edit(Project $project, Team $team)
    {
        $this->authorize('update', $project);
        
        $data = new stdClass();
        $data->module = $project;
        $data->assignedTeams = $project->assignedTeams();
        $data->unassignedTeams = $project->unassignedTeams();
        $data->module->class = get_class($data->module);
        $data->clients = Client::all();
        $data->settings = Settings::where('model','=', $data->module->class)->where('element_id','=',$data->module->id)->where('group','=','settings')->orderBy('order', 'ASC')->get();

        return view('projects/edit', compact('data'));
    }


    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $data = request()->validate([
            'name' => ['required'],
            'description' => ['required'],
            'details' => ['required'],
            'finish_date' => ['required', 'date'],
        ]);
        $project->update($data);

        return redirect("project/{$project->id}/edit");
    }

    
    public function showTasks(Project $project)
    {
        $this->authorize('view', $project);

        $data = new stdClass();
        $settings = new SettingsController;
        $data->module = $project;
        $data->status = $settings->get(get_class($data->module), $data->module->id, 'settings', 'task-status-color');
        $data->graphSize = $settings->get(get_class($data->module), $data->module->id, 'settings', 'graph-size');
        $data->allStatus = $settings->get(get_class($data->module),$data->module->id, 'settings', 'task-status');
        $data->taskStatusProgress = 0;

        $collaborating = collect([$data->module->user]);
        if ($data->module->teams->isNotEmpty()) {
            foreach ($data->module->teams as $team) {
                if ($team->collaborators->isNotEmpty()) {
                    $collaborating =
                        $collaborating->merge([$team->leader])->merge($team->collaborators)->unique('id');
                } else {
                    $collaborating = $collaborating->merge([$team->leader])->unique('id');
                }
            }
        }
        $data->collaborating = $collaborating;

        return view('/projects/partials/list-view/show', compact('project','data'));
    }

    
    public function settingsUpdate(Project $project, Settings $settings)
    {
        $this->authorize('update', Project::class);

        $data = request();
        foreach ($data->except('_token', '_method') as $key => $value)
        {
            $settingValues = explode("_", $key);
            $setting = Settings::where('model', '=', $settingValues[0])->where('element_id', '=', $settingValues[1])->where('setting', '=', $settingValues[2])->first();

            if ($setting == null)
            {
                $setting = new Settings([
                    'model' => $settingValues[0],
                    'element_id' => $settingValues[1],
                    'group'  => '',
                    'setting' => $settingValues[2],
                    'status' => $settingValues[3] ? 1 : 0,
                    'value'  => $value,
                    'policy'  => 'true',
                ]);

            } else
            {
                $setting->value = $value;
                $setting->update();
            }

            $setting->save();
        }

        return redirect("{$setting->model}/{$setting->element_id}/edit");
    }

    /*
    public function get($project)
    {
        $this->authorize('view', $project);
        return Project::find($project);
    }
    */

    public function close(Request $request)
    {
        $id = $request->input('id');     
        $project = Project::findOrFail($id);
        $this->authorize('update', $project);

        try { 
            $project->update(['status' => 'closed']);
            return 'Project status updated successfully';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }

    }


    public function open(Request $request)
    {
        $id = $request->input('id');
        $project = Project::findOrFail($id);
        $this->authorize('open', $project);

        try {
            $project->update(['status' => 'open']);
            return 'Project status updated successfully';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
