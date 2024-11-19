<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Request\UpdateCabinetRequest;
use App\Http\Resources\PersonalCabinetResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Put(
 *     path="/api/cabinet/update",
 *     summary="Update user profile information",
 *     tags={"Personal Cabinet"},
 *     operationId="UpdateUserProfile",
 *  @OA\RequestBody(
 *     required=true,
 *     description="User profile details to update",
 *      @OA\MediaType(
 *             mediaType="application/json",
 *     @OA\Schema(
 *        @OA\Property(property="name", type="string"),
 *        @OA\Property(property="email", type="string"),
 *        @OA\Property(property="password", type="string", nullable=true)
 *          )
 *      )
 *    ),
 *    @OA\Response(
 *     response=200,
 *     description="Ok",
 *     @OA\JsonContent(
 *        @OA\Property(property="name", type="string"),
 *        @OA\Property(property="email", type="string"),
 *        @OA\Property(property="password", type="string", nullable=true)
 *      )
 *  ),
 *    @OA\Response(
 *     response=400,
 *     description="Bad Request"
 *     )
 *  )
 *
 * @OA\Get(
 *     path="/api/cabinet/publication",
 *     summary="User approved publication",
 *     tags={"Personal Cabinet"},
 *     operationId="UserPublication",
 *  @OA\Response(
 *     response=200,
 *     description="List of approved publications",
 *     @OA\JsonContent(
 *      type="array",
 *      @OA\Items(
 *          @OA\Property(property="id", type="integer"),
 *          @OA\Property(property="title", type="string"),
 *          @OA\Property(property="content", type="string"),
 *          @OA\Property(property="category_id", type="integer"),
 *          @OA\Property(property="views", type="integer"),
 *          @OA\Property(property="created_at", type="string", format="date-time"),
 *          @OA\Property(property="user_id", type="integer"),
 *          @OA\Property(property="rating", type="integer"),
 *          @OA\Property(property="published", type="boolean")
 *          )
 *      )
 *   )
 * )
 *
 * @OA\Get(
 *     path="/api/cabinet/unApprovedNews",
 *     summary="User's unapproved news",
 *     tags={"Personal Cabinet"},
 *     operationId="UserUnapprovedNews",
 *     @OA\Response(
 *       response=200,
 *       description="List of unapproved news",
 *       @OA\JsonContent(
 *       type="array",
 *       @OA\Items(
 *       @OA\Property(property="title", type="string")
 *         )
 *      )
 *    )
 * )
 *
 * @OA\Get(
 *     path="/api/cabinet/rejectionNews",
 *     summary="User's rejection news",
 *     tags={"Personal Cabinet"},
 *     operationId="UserRejectionNews",
 *     @OA\Response(
 *       response=200,
 *       description="List of rejected news",
 *       @OA\JsonContent(
 *       type="array",
 *       @OA\Items(
 *       @OA\Property(property="title", type="string"),
 *       @OA\Property(property="rejection", type="string")
 *       )
 *     )
 *   )
 * )
 *
 * @OA\Put(
 *     path="/api/cabinet/unapprovedNews/{news}",
 *     summary="Update an upproved news",
 *     tags={"Personal Cabinet"},
 *     operationId="UpdateUnapprovedNews",
 *     @OA\Parameter(
 *        name="news",
 *        in="path",
 *        required=true,
 *        description="ID news",
 *     @OA\Schema(type="integer")
 *   ),
 *     @OA\RequestBody(
 *       required=true,
 *       description="Unapproved news details",
 *       @OA\MediaType(
 *         mediaType="application/json",
 *         @OA\Schema(
 *           @OA\Property(property="title", type="string"),
 *           @OA\Property(property="text", type="string"),
 *           @OA\Property(property="category_id", type="integer"),
 *           @OA\Property(property="tags", type="array", @OA\Items(type="integer")),
 *           @OA\Property(property="published", type="boolean")
 *          )
 *       )
 *    ),
 *    @OA\Response(
 *       response=200,
 *       description="Unapproved news updated",
 *       @OA\JsonContent(
 *           @OA\Property(property="title", type="string"),
 *           @OA\Property(property="text", type="string"),
 *           @OA\Property(property="category_id", type="integer"),
 *           @OA\Property(property="tags", type="array", @OA\Items(type="integer")),
 *           @OA\Property(property="published", type="boolean")
 *       )
 *    ),
 *    @OA\Response(
 *      response=400,
 *      description="News not found"
 *    )
 * )
 */

class PersonaCabinetApiController extends Controller
{
    public function update(UpdateCabinetRequest $request)
    {
        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        return response()->json($user, 200);
    }

    public function myPublication()
    {
        $user = auth()->user();
        $news = $user->news()
            ->where('checked', true)
            ->where('approved', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return PersonalCabinetResource::collection($news);
    }

    public function myUnapprovedNews()
    {
        $user = auth()->user();
        $news = $user->news()
            ->where('published', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($news, 200);
    }

    public function myRejectionNews()
    {
        $user = auth()->user();
        $rejectionNews = $user->news()
            ->where('checked', true)
            ->where('approved', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($rejectionNews, 200);
    }

    public function updateUnapprovedNews(Request $request, News $news)
    {
        $news->update([
            'title' => $request->title,
            'content' => $request->text,
            'category_id' => $request->category_id,
            'photo' => $request->hasFile('photo') ? $request->file('photo')->store('news_photos', 'public') : $news->photo,
            'published' => $request->boolean('published'),
        ]);
        if ($request->has('tags')) {
            $tagIds = $request->input('tags');
            $news->tags()->sync($tagIds);
        }

        return response()->json($news, 200);
    }
}
