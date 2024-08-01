<?php

namespace App\Http\Controllers;

use App\Models\Stage;

class StagesController extends Controller
{

    public function create(Stage $stage){
        $data = request()->validate([
            'responsible_id' => [],
            'name' => ['required'],
            'description' => ['required'],
            'details' => ['required'],
            'project_id' =>['required'],
        ]);
        $stage = auth()->user()->stages()->create($data);
        $project_id = $data['project_id'];

        return redirect()->to(url()->previous());
    }

    
    public function get($stage)
    {
        return Stage::find($stage)->first();
    }
}
