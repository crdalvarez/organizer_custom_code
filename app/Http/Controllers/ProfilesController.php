<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Team;

class ProfilesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::all();
        return view('profiles/index', compact('users'));
    }


    public function show(User $user, Post $post)
    {
        $userId = $user->id;
        $teamsAsLeader = Team::where('leader_id', '=', $user->id)->orWhere('user_id','=',$user->id)->get();
        $teamsAsCollaborator = Team::whereHas('collaborators', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        })->get();

        $allUserProjects = collect();

        foreach($teamsAsLeader as $team)
        {
            $allUserProjects = $allUserProjects->merge($team->project);

        }

        foreach($teamsAsCollaborator as $team)
        {
            $allUserProjects = $allUserProjects->merge($team->project);
        }

        $projects = $allUserProjects->unique('id');
        return view('profiles/show', compact('user', 'projects'));
    }


    public function edit(User $user)
    {
        $user = auth()->user();
        $this->authorize('update', $user->profile);
        return view('profiles/edit', compact('user'));
    }


    public function update(User $user)
    {

        $this->authorize('update', auth()->user()->profile);

        $data = request()->validate([
            'title' => ['required'],
            'image' => [],
            'description' => ['required'],
            'experience' => [],
            'skills' => [],
            'url' => [],
            'phone' => [],
            'address' => [],
            'birthdate' => [],
            'url' => [],
        ]);

        if(request('image')){
            $imagePath = request('image')->store('profile', 'public');
            $imageArray = ['image' => $imagePath];
        }

        auth()->user()->profile()->update(array_merge(
            $data,
            $imageArray ?? []));
            $user_id = auth()->user()->id;
            return redirect("profile/{$user_id}");
    }


    public function showUser()
    {
         $userId = auth()->user()->id;
         return redirect("profile/{$userId}");
    }
}
