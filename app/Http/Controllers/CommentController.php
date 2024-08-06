<?php

namespace App\Http\Controllers;

use App\Http\Request\StoreCommentRequest;
use App\Models\Comment;
use App\Models\News;
use App\Repositories\CommentRepository;
use App\Services\LikesCommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public $commentRepository;

    public function __construct (CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(StoreCommentRequest $request, News $news)
    {
        $user = auth()->user();
        if($user->isBlocked()){

            return redirect()->back();
        }
        $comments = Comment::create([
            'news_id' => $news->id,
            'parent_id' => $request->parent_id,
            'content' => $request->text,
            'user_id' => $user->id,
        ]);



        return redirect()->route('news.show', $news->id);
    }

    public function setLikeStatus(Request $request, Comment $comment, LikesCommentService $likesService)
    {
        $likeStatus = (bool)$request->input('like_status');
        $userId = $request->user()->id;
        $existingVote = $this->commentRepository->findUserCommentLikes($comment, $userId);
        $likesService->execute($comment, $userId, $existingVote, $likeStatus);

        return redirect()->back();
    }


}
