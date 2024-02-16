<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Sodium\increment;

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



    public function countLikes (Comment $comment) {

        $userId=auth()->id();
        $existingVote=Like::where('comment_id', $comment->id)->where('user_id', $userId)->first();

        if ($existingVote) {

            if ($existingVote->likes==1) {
            $comment->decrement('countLikes');
            $existingVote->delete();

        } else {
                $comment->increment('countLikes');
                $comment->decrement('countDisLikes');
                $existingVote->update(['likes' => 1, 'dislikes' => 0]);
            }
        } else {
            $comment->increment('countLikes');
            Like::create([
                'comment_id' => $comment->id,
                'user_id' => $userId,
                'likes' => 1,
            ]);
        }
        return redirect()->back();
    }

    public function countDislikes (Comment $comment) {
        $userId=auth()->id();
        $existingVote=Like::where('comment_id', $comment->id)->where('user_id', $userId)->first();
        if ($existingVote) {
            if ($existingVote->dislikes==1) {
            $comment->decrement('countDislikes');
            $existingVote->delete();

        } else {
            $comment->increment('countDislikes');
            $comment->decrement('countLikes');
            $existingVote->update(['dislikes' => 1, 'likes' => 0]);
            }
        }

            else {
            $comment->increment('countDislikes');
            Like::create([
                'comment_id' => $comment->id,
                'user_id' => $userId,
                'dislikes' => 1,
            ]);
        }
        return redirect()->back();
    }
}
