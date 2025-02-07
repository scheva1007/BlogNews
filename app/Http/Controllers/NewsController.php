<?php

namespace App\Http\Controllers;

use App\Http\Request\RatingNewsRequest;
use App\Http\Request\StoreNewsRequest;
use App\Http\Request\UpdateNewsRequest;
use App\Models\News;
use App\Models\Rating;
use App\Models\Tag;
use App\Repositories\CommentRepository;
use App\Repositories\NewsRepository;
use App\Services\CategoryService;
use App\Services\NewsService;
use App\Services\StoreNewsService;
use App\Services\UpdateNewsService;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function index(NewsService $newsService, CategoryService $categoryService)
    {
        $latestNews = $newsService->getLatestNews();
        $categories = $categoryService->getAllCategories();
        $topNews = $newsService->getTopNews();

        return view('news.index', compact('categories', 'latestNews', 'topNews'));
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
        $service->create($request);

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
        $similarNews = News::join('news_tag', 'news.id', '=', 'news_tag.news_id')
            ->whereIn('news_tag.tag_id', $tags)
            ->where('news.id', '!=', $news->id)
            ->orderBy('created_at', 'desc')
            ->select('news.*')->distinct()
            ->take(5)->get();
        $comments = $commentRepository->findNewsComments($news->id);
        $user = auth()->user();
        $subscribed = $user ? $user->subscriberAuthor($news->user_id) : false;

        return view('news.show', compact('news', 'categories', 'comments', 'similarNews', 'subscribed' ));
    }

    public function showTag($tagId)
    {
        $tag = Tag::where('id', $tagId)->firstOrFail();
        $news = News::join('news_tag', 'news.id', '=', 'news_tag.news_id')
            ->join('tags', 'news_tag.tag_id', '=', 'tags.id')
            ->where('tags.id', $tag->id)
            ->select('news.*')->distinct()
            ->paginate(5);

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
