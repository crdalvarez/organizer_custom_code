<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Timer;
use App\Models\Team;

use Carbon\Carbon;


class TimerController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->created_at ?? '0000-00-00';
        $finishDate = $request->finished_at ? Carbon::parse($request->finished_at)->endOfDay() : Carbon::create(2100, 12, 31, 23, 59, 59);
        $projectId = $request->project;
        $query = Timer::query();    

        if ($request->project) {
            $query->whereHas('task.stage.project', function ($query) use ($projectId) {
                $query->where('id', $projectId);
            });
        }

        if ($request->collaborator) {
            $query->where('user_id', $request->collaborator);
        }

        $timer = $query->where('created_at','>=',$startDate)->where('finished_at','<=',$finishDate)->orderBy('finished_at', 'DESC')->get();

        if (($request->collaborator == null)&&($request->project == null)){
            $timer = Timer::where('user_id', '=', auth()->user()->id)->where('created_at','>=',$startDate)->where('finished_at','<=',$finishDate)->orderBy('finished_at', 'DESC')->get();
        }
        
        $teams = Team::where('user_id', '=', auth()->user()->id)->get();
        $collaborators = $teams->flatMap->collaborators->unique('id');
        $projects = Project::whereHas('user.teams', function ($query) {
                $query->where('user_id', auth()->id());
            })->get(); 

        return view('timer/index', compact('timer', 'collaborators', 'projects'));
    }


    public function getProjects()
    {
        $data = Project::where('user_id', '=', auth()->user()->id)->where('status', '!=', 'closed')->get();
        return $data;
    }


    public function postRecord(Request $data)
    {
        $data = request()->validate([
            'model_id' => ['required'],
            'model' => ['required'],
            'description' => ['required'],
        ]);

        $record = auth()->user()->timer()->create($data);
        return $record;
    }

    
    public function updateRecord(Request $id)
    {
        $data = request();
        $openRecord  = Timer::where('model_id', '=', $data->id)->whereNull('finished_at')->first();
        $openRecord->finished_at = date("Y-m-d H:i:s");
        $openRecord->update();

        return $openRecord->description;
    }


    public function getIndexInTask($element_id)
    {
        $timeList = Timer::where('model_id', '=', $element_id)->whereNotNull('finished_at')->get();
        return $timeList;
    }


    public function getOpenRecord($id)
    {
        $openTrack = Timer::where('model_id', '=', $id)->whereNull('finished_at')->first();
        return $openTrack;
    }


    public function getOpenTrack($element, $id)
    {
        $openTrack = Timer::where('model', '=', 'App\Model\\' . $element)->where('model_id', '=', $id)->whereNull('finished_at')->get();
        return $openTrack;
    }
}
