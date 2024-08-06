<?php

namespace App\Http\Controllers;

use App\Commands\StoreNewsCommand;
use App\Commands\UpdateNewsCommand;
use App\Http\Request\RatingNewsRequest;
use App\Http\Request\StoreNewsRequest;
use App\Http\Request\UpdateNewsRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\News;
use App\Models\Rating;
use App\Models\Tag;
use App\Services\NewsService;
use App\Services\StoreNewsService;
use App\Services\UpdateNewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function index(NewsService $newsService)
    {
        $news = News::latest()->take(10)->get();
        $categories = Category::all();
        $topNews = $newsService->getLastNews();

        return view('news.index', compact('categories', 'news', 'topNews'));
    }

    public function allNews()
    {
        $allNews = News::latest()->paginate(5);

        return view('news.all', compact('allNews'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('news.create', compact('categories', 'tags'));
    }

    public function store(StoreNewsRequest $request, StoreNewsService $service)
    {
        $service->execute($request);

        return redirect()->route('news.index');
    }

    public function show(Request $request, News $news, Comment $comment)
    {
        $categories = Category::all();
        $viewCountKey = '$news_' .$news->id. '_view';
        if (!session()->has($viewCountKey)) {
            $news->increment('views');
            session([$viewCountKey => true]);
        }

        $tags = $news->tags->pluck('id');
        $similarNews = News::whereHas('tags', function($query) use ($tags) {
            $query->whereIn('tags.id', $tags);
        })->where('id', '!=', $news->id)
            ->orderBy('created_at', 'desc')
            ->take(5)->get();
        $comments = Comment::where('news_id', $news->id)->whereNull('parent_id')->get();

        return view('news.show', compact('news', 'categories', 'comments', 'similarNews'));
    }

    public function showTag($tagName)
    {
        $tag = Tag::where('name', $tagName)->firstOrFail();
        $news = News::whereHas('tags', function ($query) use($tag){
            $query->where('tags.id', $tag->id);
        })->paginate(5);

        return view('news.tag', compact('news', 'tag'));
    }

    public function edit(News $news)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('news.edit', compact('news', 'categories', 'tags'));
    }

    public function update(UpdateNewsRequest $request, News $news, UpdateNewsService $service)
    {
        $service->execute($request, $news);

        return redirect()->route('news.index');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('news.index');
    }

    public function rating(RatingNewsRequest $request, $newsId)
    {
        $userId = auth()->id();

        $existingRating = Rating::where('news_id', $newsId)
            ->where('user_id', $userId)->first();

        if ($existingRating) {
            $existingRating->update(['grade' => $request->input('grade')]);
        } else {
            Rating::create([
                'news_id' => $newsId,
                'user_id' => $userId,
                'grade' => $request->input('grade'),
            ]);
        }
        $newsAvgRating = Rating::where('news_id', $newsId)->avg('grade');

        News::where('id', $newsId)->update(['rating' => $newsAvgRating]);

        return redirect()->back()->with('success', "Вы успешно оценили новость");
    }
}
