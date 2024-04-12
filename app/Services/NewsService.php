<?php

namespace App\Services;

use App\Models\News;
use Carbon\Carbon;


class NewsService
{
    public function getLastNews()
    {
        $limitDays = Carbon::now()->subMonths(3);
        $topNews = News::select()->whereDate('created_at', '>=', $limitDays)
            ->orderByDesc('rating')
            ->limit(5)->get();

        if ($topNews->isEmpty()) {
            $topNews = News::select()->orderByDesc('rating')
                ->limit(5)->get();
        }

        return $topNews;
    }

    public function getSortedNews ($sortBy = 'created_at', $sortDirection = 'desc')
    {
        $query = News::query();

        if ($sortBy === 'rating')
        {
            $query->orderBy('rating', $sortDirection);
        }
        elseif ($sortBy === 'comment_count')
        {
            $query->withCount('comment')->orderBy('comment_count', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }
            return $query->paginate(3);
    }
}
