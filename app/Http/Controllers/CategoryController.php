<?php

namespace App\Http\Controllers;

use App\Models\Category;
use function Doctrine\Common\Cache\Psr6\get;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $categories = Category::query()->whereNotIn('id', [$category->id])->get();
        $news=$category->news;
        return view('category.show', compact('news', 'category', 'categories'));
    }
}
