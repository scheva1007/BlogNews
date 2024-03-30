<?php


namespace App\Commands;


use App\Models\Comment;
use App\Models\Like;

class LikesCommentCommand
{
    public function execute(Comment $comment, $existingVote)
    {
        if ($existingVote) {
            if ($existingVote->likes == 1) {
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
    }
}
