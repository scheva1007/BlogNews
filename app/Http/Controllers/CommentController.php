<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, News $news)
    {
        $user=auth()->user();
        if(!$user ){
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'text' =>'required',
        ]);

        $comment=$news->comment()->create([
            'content' => $request->text,
            'user_id' => $user->id,
        ]);

        return redirect()->back()->with('commentAdded', $comment);
    }

    public function destroy(Comment $comment)
    {
        $user=auth()->user();
        if(!$user || !$user->isAdmin() && !$user->isAuthor()){
            abort(403, 'Unauthorized action.');
        }
         $comment->delete();
         return redirect()->back;
    }
}
