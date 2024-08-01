<?php

namespace App\Http\Controllers;

class PostsController extends Controller
{

    public function store()
    {
        $data = request()->validate([
            'post' => ['required'],
            'file' => [],
        ]);

        if (request()->hasFile('file')) {
            $filePath = request()->file('file')->store('uploads', 'public');
        } else {
            $filePath = '';
        }
        
        $user_id = auth()->user()->id;

        auth()->user()->posts()->create([
            'post' => $data['post'],
            'file' => $filePath,
            'user_id' => $user_id,
        ]);

        return redirect('/profile/' . $user_id);
    }
}
