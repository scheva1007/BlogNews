<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function create()
    {
        $categories = Category::all();

        return view('category.create', compact('categories'));
    }

    public function store (Request $request)
    {
        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('news.index');
    }
    public function show(Category $category)
    {
        $categories = Category::query()->where('id', '!=', [$category->id])->get();
        $news=$category->news;

        return view('category.show', compact('news', 'category', 'categories'));
    }
}
