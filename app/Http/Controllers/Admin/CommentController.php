<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notification;
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
        $statusSelection = ['verified',  'blocked'];
        $blockingTime = ['1', '7', '30', '10000'];

        return view('comments.edit', compact('comment', 'statusSelection', 'blockingTime'));
    }

    public function update (Request $request, Comment $comment)
    {
        $comment->update([
            'status' => $request->status
        ]);

        if ($comment->parent_id && $comment->status == 'verified') {
            $parentComment = Comment::find($comment->parent_id);
            Notification::create([
                'user_id' => $parentComment->user_id,
                'news_id' => $comment->news_id,
                'message_type' => 'comment_reply',
                'additional_info' => $comment->id,
            ]);
        }

        return redirect()->route('comment.index', $comment->id);
    }
}
