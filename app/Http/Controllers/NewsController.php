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
use App\Services\NewsService;

class NewsController extends Controller
{

    public function index(NewsService $newsService)
    {
        $news = News::latest()->paginate(5);
        $categories = Category::all();
        $topNews = $newsService->getLastNews();

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

    public function show(News $news)
    {
        $categories = Category::all();

        $viewCountKey = '$news_' .$news->id. '_view';
        if (!session()->has($viewCountKey)) {
            $news->increment('views');
            session([$viewCountKey => true]);
        }

        return view('news.show', compact('news', 'categories'));
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

    public function rating(RatingNewsRequest $request, $newsId, RatingNewsCommand $command)
    {
        $userId = auth()->id();

        $existingRating = Rating::where('news_id', $newsId)
            ->where('user_id', $userId)->first();

        if ($existingRating) {
            $existingRating->update(['grade' => $request->input('grade')]);
        } else {
             $command->execute($request, $newsId, $userId);
        }
        $newsAvgRating = Rating::where('news_id', $newsId)->avg('grade');

        News::where('id', $newsId)->update(['rating' => $newsAvgRating]);

        return redirect()->back()->with('success', "Вы успешно оценили новость");
    }
}
