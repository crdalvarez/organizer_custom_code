<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use App\Models\Team;

class FeaturesController extends Controller
{
    public function dashboard(User $user)
    {
        $user = auth()->user();
        $today = Carbon::now()->toDateString();
        $projects = Project::where('user_id', '=', $user->id)->orderBy('created_at', 'DESC')->get();
        $teams = Team::where('user_id', '=', $user->id)->orderBy('created_at', 'DESC')->get();
        $tasks_completed = count(Task::where('user_id', '=', $user->id)->where('status', '=', 'closed')->orderBy('created_at', 'DESC')->get());
        $tasks_overdue = count(Task::where('user_id', '=', $user->id)->where('status', 'not like', 'closed')->where('finish_date', '<', $today)->orderBy('created_at', 'DESC')->get());
        $tasks_active = count(Task::where('user_id', '=', $user->id)->where('start_date', '<', $today)->where('finish_date', '>', $today)->where('status', 'not like', 'closed')->orderBy('created_at', 'DESC')->get());
        $tasks_upcomming = count(Task::where('user_id','=',$user->id)->where('start_date','>',$today)->where('status','not like','closed')->orderBy('created_at')->get());
        $tasks = Task::where('user_id', '=', $user->id)->whereNot('status','closed')->orderBy('start_date', 'DESC')->get();
        $event = [];
        foreach ($tasks as $task) {
            $event[] = [
                'url' => route('task.show', $task->id),
                'title' => $task->name,
                'start' => $task->start_date,
                'end' => $task->finish_date,
                'backgroundColor' => 'light-blue',
                'border' => '$fff',
                'editable' => true,
                'textColor' => '#fff',

            ];
        }

        return view('/dashboard', compact('projects', 'teams', 'tasks_overdue', 'tasks_completed','tasks_upcomming', 'tasks_active', 'event', 'tasks', 'user'));
    }


    public function calendar(Task $task, User $user, $display)
    {

        $user = auth()->user();
        $tasks = Task::where('user_id', '=', $user->id)->orderBy('created_at', 'DESC')->get();
        $event = [];
        foreach ($tasks as $task) {
            $event[] = [
                'url' => route('task.show', ['task' => $task->id]),
                'title' => $task->name,
                'start' => $task->start_date,
                'end' => $task->finish_date,
                'backgroundColor' => 'light-blue',
                'border' => 'blue',
                'editable' => true,
                'backgroundColor' => 'light-blue',
                'textColor' => '#fff',
            ];
        }

        return view('/tools/calendar', compact('event', 'display'));
    }


    public function plugins()
    {
        return view('/extensions/show');
    }

    public function about()
    {
        return view('/information');
    }
}
