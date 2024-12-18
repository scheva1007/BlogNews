<?php


namespace App\Repositories;

use App\Models\News;

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
}


