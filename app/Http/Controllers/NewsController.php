<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news=News::latest()->paginate(5);
        $categories=Category::all();

        return  view('news.index', compact('categories', 'news'));
    }

    public function create()
    {
        $categories=Category::all();

        return view ('news.create', compact('categories'));

    }

    public function store(Request $request)
    {
         $request->validate([
             'title' =>' required',
             'text' => 'required',
             'category_id' => 'required|exists:categories,id',
         ]);

         News::create([
             'title' => $request->title,
             'content' => $request->text,
             'category_id' => $request->category_id,
         ]);

         return redirect()->route('news.index');
    }

    public function show(News $news)
    {
        $comments=$news->comment;

        return view('news.show', compact('news','comments'));
    }

    public function edit (News $news)
    {
        $categories=Category::all();
        return view('news.edit', compact('news', 'categories'));
    }

    public function update (Request $request, News $news)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        $news->update([
            'title' => $request->title,
            'content' => $request->text,
            'category_id' => $request->category_id,
        ]);
        return redirect()->route('news.index');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index');
    }
}
