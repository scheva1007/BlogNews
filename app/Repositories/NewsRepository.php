<?php


namespace App\Repositories;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class NewsRepository
{
    public function findPublishedAndApprovedNews()
    {
        return News::where('published', true)
            ->where('checked', true)
            ->where('approved', true)
            ->withCount('comment')
            ->latest()->take(10)->get();
    }

    public function get5MostViewedNews()
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
                    ->where('approved', true)
                    ->withCount('comment')
                    ->orderByDesc('rating')
                    ->limit(5)->get();
            }
            return $topNews;
        });
    }
}


