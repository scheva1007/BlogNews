<?php

namespace App\Http\Controllers;

use App\Commands\StoreNewsCommand;
use App\Commands\UpdateNewsCommand;
use App\Http\Request\StoreNewsRequest;
use App\Http\Request\UpdateNewsRequest;
use App\Models\Category;
use App\Models\News;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $user = auth()->user();
        if (!$user || !$user->isAdmin() && !$user->isAuthor()) {
            abort(403, 'Unauthorized action.');
        }
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
        $user = auth()->user();
        if (!$user || !$user->isAdmin() && !$user->isAuthor()) {
            abort(403, 'Unauthorized action.');
        }

        $command->execute($request, $news);

        return redirect()->route('news.index');
    }

    public function destroy(News $news)
    {
        $user = auth()->user();
        if (!$user || !$user->isAdmin() && !$user->isAuthor()) {
            abort(403, 'Unauthorized action.');
        }
        $news->delete();
        return redirect()->route('news.index');
    }

    public function rating(Request $request, $id)
    {
        $request->validate([
            'grade' => 'required|integer|min:1|max:5',
        ]);

        $userId = auth()->id();

        $existingRating = Rating::where('news_id', $id)
            ->where('user_id', $userId)->first();

        if ($existingRating) {
            $existingRating->update(['grade' => $request->input('grade')]);
        } else {
            Rating::create([
                'news_id' => $id,
                'user_id' => $userId,
                'grade' => $request->input('grade'),
            ]);
        }
        $newRating = Rating::where('news_id', $id)->avg('grade');

        News::where('id', $id)->update(['rating' => $newRating]);

        return redirect()->back()->with('success', "Вы успешно оценили новость");
    }
}
