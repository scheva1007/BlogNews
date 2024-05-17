<?php

namespace App\Http\Controllers;

use App\Commands\LikesCommentCommand;
use App\Commands\StoreCommentCommand;
use App\Http\Request\StoreCommentRequest;
use App\Models\Comment;
use App\Models\News;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public $commentRepository;

    public function __construct (CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(StoreCommentRequest $request, News $news, StoreCommentCommand $command)
    {
        $user = auth()->user();
        $comment = $command->execute($request, $news, $user);

        return response()->view('news.partials.comment', compact ('comment'));
    }

    public function setLikeStatus(Request $request, Comment $comment, LikesCommentCommand $likesCommand)
    {
        $likeStatus = (bool)$request->input('like_status');
        $userId = $request->user()->id;
        $existingVote = $this->commentRepository->findUserCommentLikes($comment, $userId);
        $likesCommand->execute($comment, $userId, $existingVote, $likeStatus);

        return redirect()->back();
    }
}
