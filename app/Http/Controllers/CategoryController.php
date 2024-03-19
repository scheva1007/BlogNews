<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $news=$category->news;
        return view('category.show', compact('news', 'category'));
    }
}
