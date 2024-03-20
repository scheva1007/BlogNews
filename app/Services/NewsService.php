<?php


namespace App\Services;

use App\Models\News;
use Carbon\Carbon;

class NewsService
{
    public function getLastNews()
    {
        $limitDays = Carbon::now()->subDays(7);
        $topNews = News::select()->whereDate('created_at', '>=', $limitDays)
            ->orderByDesc('rating')->limit(5)->get();

        if ($topNews->isEmpty()) {
            $topNews = News::select()->orderByDesc('rating')->limit(5)->get();
        }
        return $topNews;
    }
}
