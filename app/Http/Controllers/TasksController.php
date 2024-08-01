<?php

namespace App\Http\Controllers;

use \stdClass;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use App\Models\Stage;
use App\Models\Project;


class TasksController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Task $task)
    {
        $this->authorize('viewAny', Task::class);
        $tasks = Task::where('user_id', auth()->user()->id)->where('status', 'open')->get();
        return view('tasks/index', compact('tasks'));
    }


    public function new()
    {
        $this->authorize('create', Task::class);
        return view('tasks/new');
    }

    public function create()
    {
        $this->authorize('create', Task::class);
        
        $data = request()->validate([
            'name' => ['required'],
            'description' => ['required'],
            'responsible_id' => ['required'],
            'details' => ['required'],
            'start_date' => ['required', 'date'],
            'finish_date' => ['required', 'date'],
            'stage_id' => ['required'],
            'status' => ['required'],
            'priority' => ['required'],
            'progress' => ['required'],
        ]);

        $task = auth()->user()->tasks->create($data);
        return redirect()->to(url()->previous());
    }

 
    public function show(Task $task, Comment $comments, User $user)
    {
        $this->authorize('view', $task);
        $data = new stdClass();
        $data->module = $task;
        $data->comments = $task->comments;
        $data->commentableType = Task::class;
        $data->module->allProgress = (new SettingsController)->get(get_class($data->module->stage->project), $data->module->stage->project->id, 'settings', 'task-status');
        //$allStatusColor = (new SettingsController)->get(get_class($data->module->stage->project), $data->module->stage->project->id, 'settings', 'task-status-color');
        
        return view('tasks/show',  compact('data'));
    }


    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return view('tasks/edit', compact('task'));
    }


    public function delete(Request $request)
    {
        try {
            $task = Task::findOrFail($request->id);
            $this->authorize('update', $task);
            $task->delete();
            return response()->json(['message' => 'Task deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete task: ' . $e->getMessage()], 500);
        }
    }


    public function update(Task $task)
    {
        $this->authorize('update', $task);

        $data = request()->validate([
            'responsible_id' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
            'details' => ['required'],
            'start_date' => ['required', 'date'],
            'finish_date' => ['required', 'date'],
        ]);
        
        Task::find($task->id)->update($data);

        return redirect("task/{$task->id}");
    }


    public function getStatus($id)
    {
        return Task::find($id);
    }


    public function updateStatus(Request $id)
    {
        $task = Task::find($id['id']);
        if ($task->status == 'closed') {
            $task->status = 'open';
        } else {
            $task->status = 'closed';
        }
        $task->update();
        return $task->status;
    }


    public function updateProgress()
    {
        $data = request()->validate([
            'task' => ['required'],
            'progress' => ['required'],
        ]);
        $task = Task::find($data['task']);
        $task->progress = $data['progress'];
        $task->update();

        return redirect()->to(url()->previous());
    }

}
