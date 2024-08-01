<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamsController extends Controller
{

    public function index(Team $team, User $user)
    {
        $userId = auth()->user()->id;
        $this->authorize('viewAny', Team::class);
        $userTeams = Team::where('user_id', $userId)->orWhere('leader_id', $userId)->get();
        $collaboratingTeams = $user->collaboratingTeams;
        $teams = $userTeams->merge($collaboratingTeams)->unique('id');

        return view('teams/index', compact('teams'));
    }


    public function new()
    {
        $this->authorize('create', Team::class);
        $users = User::all();
        return view('teams/new', compact('users'));
    }


    public function create()
    {
        $this->authorize('create', Team::class);

        $data = request()->validate([
            'name' => ['required'],
            'description' =>  ['required'],
            'details' =>  ['required'],
            'leader_id' => ['required'],
        ]);
        $data['user_id'] = auth()->user()->id;
        $team = auth()->user()->teams()->create($data);

        return redirect('team/'.$team->id);
    }


    public function show(Team $team)
    {
        $this->authorize('view', $team);
        return view('teams/show', compact('team'));
    }


    public function edit(Team $team)
    {
        $this->authorize('update', $team);
        return view('teams/edit', compact('team'));
    }


    public function update(Request $request)
    {
        $team = Team::find($request->id);
        $this->authorize('update', $team);
    
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'details' => ['required'],
        ]);
    
        $team->update($data);
    
        return redirect()->route('team.show', ['team' => $team->id]);
    }


}
