<?php

namespace App\Http\Controllers;

use App\Http\Request\StoreCommentRequest;
use App\Models\Comment;
use App\Models\News;
use App\Repositories\CommentRepository;
use App\Services\LikesCommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, News $news)
    {
        $user = Auth::user();
        if($user->isBlocked()){

            return redirect()->back();
        }
        $comments = Comment::create([
            'news_id' => $news->id,
            'parent_id' => $request->parent_id,
            'content' => $request->text,
            'user_id' => $user->id,
        ]);

        return redirect()->route('news.show', $news->id)->with('success', 'Ваш коментар з\'явиться після одобрення адміном.');
    }

    public function setLikeStatus(Request $request, Comment $comment, LikesCommentService $likesService, CommentRepository $commentRepository)
    {
        $likeStatus = (bool)$request->input('like_status');
        $userId = $request->user()->id;
        $existingVote = $commentRepository->findUserCommentLikes($comment, $userId);
        $likesService->setLikeOrDislike($comment, $userId, $existingVote, $likeStatus);

        return redirect()->back();
    }
}
