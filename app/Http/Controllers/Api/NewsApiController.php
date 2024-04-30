<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsIndexResource;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsApiController extends Controller
{
    public function index (Request $request, NewsService $newsService)
    {
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDirection = $request->query('sort_direction', 'desc');
        $news = $newsService->getSortedNews($sortBy, $sortDirection);

        return NewsIndexResource::collection($news);
    }

    public function
}
