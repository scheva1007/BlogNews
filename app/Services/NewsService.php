<?php

namespace App\Services;

use App\Models\News;
use App\Repositories\NewsRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;


class NewsService
{
    public $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function getTopNews()
    {
        $cacheKey = 'top_news';
        $cacheDuration = 60 * 60;

        return Cache::remember($cacheKey, $cacheDuration, function () {
            $limitDays = Carbon::now()->subMonths(6);
            $topNews = News::select()->where('published', true)
                ->where('checked', true)
                ->where('approved', true)
                ->whereDate('created_at', '>=', $limitDays)
                ->withCount('comment')
                ->orderByDesc('views')
                ->limit(5)->get();

            if ($topNews->isEmpty()) {
                $topNews = News::select()
                    ->where('checked', true)
                    ->withCount('comment')
                    ->orderByDesc('rating')
                    ->limit(5)->get();
            }

            return $topNews;
        });
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
