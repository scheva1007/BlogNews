<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index ()
    {
        $comments = Comment::where('status', 'not verified')->get();

        return view('comments.index', compact('comments'));
    }

    public function edit (Comment $comment)
    {
        $statusSelection = ['verified', 'blocked'];

        return view('comments.edit', compact('comment', 'statusSelection'));
    }

    public function update (Request $request, Comment $comment)
    {
        $comment->update([
            'status' => $request->status
        ]);

        return redirect()->route('comment.index');
    }
}