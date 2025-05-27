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

    public function findNewsComments($newsId)
    {
        return Comment::where('news_id', $newsId)->whereNull('parent_id')
            ->where('status', 'verified')
            ->with('replies')
            ->orderBy('created_at', 'desc')->get();

    }
}
