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
