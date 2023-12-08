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
        $request->validate([
            'text' =>'required',
        ]);

        $news->comment()->create([
            'content' => $request->text,
            'user_id' => 1,
        ]);

        return redirect()->back();
    }

    public function destroy(Comment $comment)
    {
         $comment->delete();
         return redirect()->back;
    }
}
