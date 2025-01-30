<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Request\StoreCommentRequest;
use App\Models\Comment;
use App\Models\News;
use App\Repositories\CommentRepository;
use App\Services\LikesCommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Post(
 *     path="/api/news/{news}/comments",
 *     summary="add a comment before the news",
 *     tags={"Comments"},
 *     operationId="storeComment",
 *     @OA\Parameter(
 *        name="news",
 *        in="path",
 *        required=true,
 *        description="ID news",
 *        @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *        required=true,
 *        @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="content", type="string"),
 *                 @OA\Property(property="parent_id", type="integer"),
 *             )
 *        )
 *     ),
 *     @OA\Response(
 *     response=201,
 *     description="OK",
 *          @OA\JsonContent(
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="content", type="string"),
 *                 @OA\Property(property="parent_id", type="integer"),
 *          )
 *     ),
 *     @OA\Response(response=403, description="You are blocked and cannot comment.")
 * )
 *
 * *@OA\Get(
 *     path="/api/news/{comment}/like-status",
 *     summary="like/dislike comment",
 *     tags={"Comments"},
 *     operationId="likeDisLikeComment",
 *     @OA\Parameter(
 *         name="comment",
 *         in="path",
 *         required=true,
 *         description="ID comment",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *      ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                  @OA\Property(property="like_status", type="boolean")
 *             )
 *           )
 *      ),
 *     @OA\Response(
 *          response=200,
 *          description="OK"
 *     )
 * )
 */

class CommentApiController extends Controller
{
    public $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(StoreCommentRequest $request, News $news)
    {
        $user = Auth::user();
        if ($user->isBlocked()) {
            return response()->json(['error' => 'Ви заблоковані і не можете коментувати.'], 403);
        }

        $comment = Comment::create([
            'news_id' => $news->id,
            'parent_id' => $request->parent_id,
            'content' => $request->text,
            'user_id' => $user->id,
        ]);

        return response()->json(['comment' => $comment], 201);
    }

    public function setLikeStatus(Request $request, Comment $comment, LikesCommentService $likesService)
    {
        $likeStatus = (bool)$request->input('like_status');
        $userId = $request->user()->id;
        $existingVote = $this->commentRepository->findUserCommentLikes($comment, $userId);
        $likesService->execute($comment, $userId, $existingVote, $likeStatus);

        return response()->json(null, 200);
    }
}
