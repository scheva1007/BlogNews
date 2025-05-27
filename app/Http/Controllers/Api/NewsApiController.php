<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Request\StoreNewsApiRequest;
use App\Http\Request\UpdateNeawsApiRequest;
use App\Http\Resources\NewsIndexResource;
use App\Models\News;
use App\Services\NewsService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/news",
 *     summary="Create a new news item",
 *     tags={"News"},
 *     operationId="storeNews",
 *     @OA\RequestBody(
 *         required=true,
 *         description="News item details",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="title", type="string"),
 *                 @OA\Property(property="text", type="string"),
 *                 @OA\Property(property="category_id", type="integer"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Created",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="content", type="string"),
 *             @OA\Property(property="category_id", type="integer"),
 *             @OA\Property(property="user_id", type="integer"),
 *         )
 *     )
 * )
 *
 * * @OA\Get(
 *     path="/api/news/{news}",
 *     summary="Get a news item by ID",
 *     tags={"News"},
 *     operationId="showNews",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the news item",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="content", type="string"),
 *             @OA\Property(property="category_id", type="integer"),
 *             @OA\Property(property="user_id", type="integer"),
 *         )
 *     )
 * )
 *
 *  * @OA\Put(
 *     path="/api/news/{news}",
 *     summary="Update a news item",
 *     tags={"News"},
 *     operationId="updateNews",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the news item",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Updated news item details",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="title", type="string"),
 *                 @OA\Property(property="text", type="string"),
 *                 @OA\Property(property="category_id", type="integer"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="content", type="string"),
 *             @OA\Property(property="category_id", type="integer"),
 *             @OA\Property(property="user_id", type="integer"),
 *         )
 *     )
 * )
 *
 * * @OA\Delete(
 *     path="/api/news/{news}",
 *     summary="Delete a news item",
 *     tags={"News"},
 *     operationId="destroyNews",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the news item",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="No Content"
 *     )
 * )
 */

class NewsApiController extends Controller
{
    public function index(Request $request, NewsService $newsService)
    {
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDirection = $request->query('sort_direction', 'desc');
        $news = $newsService->getSortedNews($sortBy, $sortDirection);

        return NewsIndexResource::collection($news);
    }

    public function store(StoreNewsApiRequest $request)
    {
        $news = News::create([
            'title' => $request->title,
            'content' => $request->text,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
        ]);

        return response()->json($news, 201);
    }

    public function show(News $news)
    {
        return response()->json($news);
    }

    public function update (UpdateNeawsApiRequest $request, News $news)
    {
        $news->update([
            'title' => $request->title,
            'content' => $request->text,
            'category_id' => $request->category_id,
        ]);

        return response()->json($news, 200);
    }

    public function destroy (News $news)
    {
        $news->delete();

        return response()->json(null, 204);
    }
}
