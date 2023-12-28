<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $user=auth()->user();
        if(!$user || !$user->isAdmin() && !$user->isAuthor()){
            abort(403, 'Unauthorized action.');
        }
        $categories=Category::all();

        return view ('news.create', compact('categories'));

    }

    public function store(Request $request)
    {
         $request->validate([
             'title' =>' required',
             'text' => 'required',
             'category_id' => 'required|exists:categories,id',
             'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);

         $news=News::create([
             'title' => $request->title,
             'content' => $request->text,
             'category_id' => $request->category_id,
         ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('news_photos', 'public');
            $news->update(['photo' => $photoPath]);
        }

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

        $user=auth()->user();
        if(!$user || !$user->isAdmin() && !$user->isAuthor()){
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $news->update([
            'title' => $request->title,
            'content' => $request->text,
            'category_id' => $request->category_id,
            'photo' => $request->hasFile('photo') ? $request->file('photo')->store('news_photos', 'public') : $news->photo,
        ]);


        return redirect()->route('news.index');
    }

    public function destroy(News $news)
    {
        $user=auth()->user();
        if(!$user || !$user->isAdmin() && !$user->isAuthor()){
            abort(403, 'Unauthorized action.');
        }
        $news->delete();
        return redirect()->route('news.index');
    }
}
