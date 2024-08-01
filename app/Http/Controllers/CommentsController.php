<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\File;

class CommentsController extends Controller
{
    public function create(User $user, Request $request)
    {
        $data = $request->validate([
            'commentable_type' => 'required',
            'commentable_id' => 'required',
            'comment' => 'required',
            'file' => [],
        ]);

        $user = auth()->user();

        $filePath = '';

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
        }

        $comment = Comment::create([
            'commentable_type' => $data['commentable_type'],
            'commentable_id' => $data['commentable_id'],
            'comment' => $data['comment'],
            'file' => $filePath,
            'user_id' => $user->id,
        ]);

        $url = strtolower(class_basename($data['commentable_type'])) . '/' . $data['commentable_id'];

        return redirect('/' . $url);
    }

    public function show($object)
    {

        $user_name = '';
        $comments = new Comment();
        $allComments = $comments->objectComments($object);

        if (!empty($allComments)) {
            foreach ($allComments as $comment) {
                if (!empty($comment->file)) {
                    $extension = File::extension($comment->file);

                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'], true)) {
                        $comment->file = '<img src=/storage/' . $comment->file . ' class="image-fluid" style="width: 100%; height: auto;"/>';
                    } else {
                        $comment->file = '<a href=' . $comment->file . '>' . $comment->file . '</a>';
                    }
                }
                $user = new User();

                $comment->username = $user->username($comment->user_id);
            }
            return $allComments;
        } else {
            $all_comments = '';
        }
    }
}
