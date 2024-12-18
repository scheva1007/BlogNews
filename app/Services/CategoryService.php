<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    public function getAllCategories()
    {
        return $categories = Cache::remember('categories', 3600, function () {
            return Category::all();
        });
    }
}
