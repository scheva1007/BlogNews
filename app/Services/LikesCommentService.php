<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\CommentLikes;

class LikesCommentService
{
    public function execute(Comment $comment, $userId, $existingVote, $likeStatus)
    {
        if ($existingVote) {

            if ($existingVote->like_status == $likeStatus) {
                if ($likeStatus) {
                    $comment->decrement('countLikes');
                } else {
                    $comment->decrement('countDislikes');
                }
                $existingVote->delete();

            } else {
                if ($likeStatus) {
                    $comment->increment('countLikes');
                    $comment->decrement('countDislikes');

                } else {
                    $comment->increment('countDislikes');
                    $comment->decrement('countLikes');
                }
                $existingVote->update(['like_status' => $likeStatus]);
            }
        } else {
            if ($likeStatus ) {
                $comment->increment('countLikes');
            } else {
                $comment->increment('countDislikes');
            }
            CommentLikes::create([
                'comment_id' => $comment->id,
                'user_id' => $userId,
                'like_status' => $likeStatus,
            ]);
        }
    }
}
