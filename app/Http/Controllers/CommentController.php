<?php

namespace App\Http\Controllers;

use App\Commands\LikesCommentCommand;
use App\Commands\StoreCommentCommand;
use App\Http\Request\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Like;
use App\Models\News;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, News $news, StoreCommentCommand $command)
    {
        $user = auth()->id();
        $comment = $command->execute($request, $news, $user);

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back;
    }

    public function countLikes(Comment $comment, LikesCommentCommand $likesCommand)
    {
        $userId = auth()->id();
        $existingVote = Like::where('comment_id', $comment->id)->where('user_id', $userId)->first();

       $likesCommand->execute($comment,$userId, $existingVote);
        return redirect()->back();
    }

    public function countDislikes(Comment $comment)
    {
        $userId = auth()->id();
        $existingVote = Like::where('comment_id', $comment->id)->where('user_id', $userId)->first();
        if ($existingVote) {
            if ($existingVote->dislikes == 1) {
                $comment->decrement('countDislikes');
                $existingVote->delete();
            } else {
                $comment->increment('countDislikes');
                $comment->decrement('countLikes');
                $existingVote->update(['dislikes' => 1, 'likes' => 0]);
            }
        } else {
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
