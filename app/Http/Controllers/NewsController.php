<?php

namespace App\Http\Controllers;

use App\Commands\RatingNewsCommand;
use App\Commands\StoreNewsCommand;
use App\Commands\UpdateNewsCommand;
use App\Http\Request\RatingNewsRequest;
use App\Http\Request\StoreNewsRequest;
use App\Http\Request\UpdateNewsRequest;
use App\Models\Category;
use App\Models\News;
use App\Models\Rating;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(5);
        $categories = Category::all();
        $limitMonths = Carbon::now()->subMonths(3);
        $topNews = News::select()->whereDate('created_at', ">=", $limitMonths)->orderByDesc('rating')->limit(3)->get();

        return view('news.index', compact('categories', 'news', 'topNews'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('news.create', compact('categories'));
    }

    public function store(StoreNewsRequest $request, StoreNewsCommand $command)
    {
        $command->execute($request);

        return redirect()->route('news.index');
    }

    public function show($id)
    {
        $userId = auth()->id();
        $news = News::findOrFail($id);
        $comments = $news->comment;
        $rating = $news->rating;
        $userRating = $news->userRating();

        return view('news.show', compact('news', 'comments', 'rating', 'userRating', 'userId'));
    }

    public function edit(News $news)
    {
        $categories = Category::all();
        return view('news.edit', compact('news', 'categories'));
    }

    public function update(UpdateNewsRequest $request, News $news, UpdateNewsCommand $command)
    {
        $command->execute($request, $news);

        return redirect()->route('news.index');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index');
    }

    public function rating(RatingNewsRequest $request, $id, RatingNewsCommand $command)
    {
        $userId = auth()->id();

        $existingRating = Rating::where('news_id', $id)
            ->where('user_id', $userId)->first();

        if ($existingRating) {
            $existingRating->update(['grade' => $request->input('grade')]);
        } else {
             $command->execute($request, $id, $userId);
        }
        $newRating = Rating::where('news_id', $id)->avg('grade');

        News::where('id', $id)->update(['rating' => $newRating]);

        return redirect()->back()->with('success', "Вы успешно оценили новость");
    }
}
