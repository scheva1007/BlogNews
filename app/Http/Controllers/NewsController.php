<?php

namespace App\Http\Controllers;

use App\Http\Request\RatingNewsRequest;
use App\Http\Request\StoreNewsRequest;
use App\Http\Request\UpdateNewsRequest;
use App\Models\Comment;
use App\Models\News;
use App\Models\Rating;
use App\Models\Tag;
use App\Repositories\CommentRepository;
use App\Repositories\NewsRepository;
use App\Services\CategoryService;
use App\Services\NewsService;
use App\Services\StoreNewsService;
use App\Services\UpdateNewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function index(NewsService $newsService, CategoryService $categoryService, NewsRepository $newsRepository)
    {
        $news = Cache::remember('latest_news', 3600, function () use ($newsRepository) {

            return $newsRepository->findPublishedAndApprovedNews();
        });
        $categories = $categoryService->getAllCategories();
        $topNews = $newsService->getLastNews();

        return view('news.index', compact('categories', 'news', 'topNews'));
    }

    public function allNews()
    {
        $allNews = News::where('published', true)
            ->where('checked', true)
            ->where('approved', true)
            ->latest()->paginate(5);

        return view('news.all', compact('allNews'));
    }

    public function create(CategoryService $categoryService)
    {
        $categories = $categoryService->getAllCategories();
        $tags = Tag::all();

        return view('news.create', compact('categories', 'tags'));
    }

    public function store(StoreNewsRequest $request, StoreNewsService $service)
    {
        $service->execute($request);

        return redirect()->route('news.index');
    }

    public function show(News $news, CategoryService $categoryService, CommentRepository $commentRepository)
    {
        $categories = $categoryService->getAllCategories();
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
        $comments = $commentRepository->findNewsComments($news->id);
        $user = auth()->user();
        $subscribed = $user ? $user->subscriberAuthor($news->user_id) : false;

        return view('news.show', compact('news', 'categories', 'comments', 'similarNews', 'subscribed' ));
    }

    public function showTag($tagName)
    {
        $tag = Tag::where('name', $tagName)->firstOrFail();
        $news = News::whereHas('tags', function ($query) use($tag){
            $query->where('tags.id', $tag->id);
        })->paginate(5);

        return view('news.tag', compact('news', 'tag'));
    }

    public function edit(News $news, CategoryService $categoryService)
    {
        $categories = $categoryService->getAllCategories();
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
