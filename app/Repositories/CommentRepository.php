<?php


namespace App\Repositories;


use App\Models\Comment;
use App\Models\CommentLikes;

class CommentRepository
{
    public function findUserCommentLikes (Comment $commentId, $userId)
    {
       return CommentLikes::where('comment_id', $commentId->id)->where('user_id', $userId)->first();
    }
}
