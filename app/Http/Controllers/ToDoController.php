<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDo;

class ToDoController extends Controller
{

    public function indexGeneral()
    {
        $data = ToDo::where('user_id','=', auth()->user()->id)->where('status','=',0)->get();

        foreach($data as $toDo){
            $toDo->task_id = $toDo->task->id;
            $toDo->task_name = $toDo->task->name;
            $toDo->project_id = $toDo->task->stage->project->id;
            $toDo->project_name = $toDo->task->stage->project->name;
        }

        return $data;
    }


    public function index($element, $id)
    {
        $data = ToDo::where('element', '=', $element)->where('element_id', '=', $id)->get();
        return $data;
    }


    public function store()
    {
        $data = request()->validate([
            'element' => ['required'],
            'element_id' => ['required'],
            'value' => ['required'],
        ]);

        $data['status'] = 0;
        $newToDo = auth()->user()->todo()->create($data);
        
        return $newToDo;
    }


    public function delete(Request $itemId)
    {
        $item = ToDo::find($itemId['id']);
        $item->delete();
    }


    public function update(Request $itemId)
    {
        $item = ToDo::find($itemId['id']);
        $item->status = ! $item->status;
        $item->update();
    }

}
