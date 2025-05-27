<?php

namespace App\Services;

use App\Models\News;
use App\Repositories\NewsRepository;
use Illuminate\Support\Facades\Cache;

class NewsService
{
    public $newsRepository;


    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function getSortedNews($sortBy = 'created_at', $sortDirection = 'desc')
    {
        $query = News::query();

        if ($sortBy === 'rating') {
            $query->orderBy('rating', $sortDirection);
        } elseif ($sortBy === 'comment_count') {
            $query->withCount('comment')->orderBy('comment_count', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }
        return $query->paginate(3);
    }

    public function getLatestNews()
    {
        return Cache::remember('latest_news', 3600, function () {
            return $this->newsRepository->findPublishedAndApprovedNews();
        });
    }
}
