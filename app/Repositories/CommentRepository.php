<?php


namespace App\Repositories;

use App\Models\Comment;
use App\Models\CommentLikes;

class CommentRepository
{
    public function findUserCommentLikes ($comment, $userId)
    {
       return CommentLikes::where('comment_id', $comment->id)->where('user_id', $userId)->first();
    }
}
