<?php


namespace App\Repositories;


use App\Models\Comment;
use App\Models\Like;

class CommentRepository
{
    public function findUserCommentLikes ($comment, $userId)
    {
       return Like::where('comment_id', $comment->id)->where('user_id', $userId)->first();
    }
}
