<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news=News::latest()->paginate(5);
        $categories=Category::all();
        $limitDays=Carbon::now()->subDays(5);
        $topNews=News::select()->whereDate('created_at', ">=", $limitDays)->orderByDesc('rating')->limit(3)->get();


        return  view('news.index', compact('categories', 'news', 'topNews'));
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
             'user_id' => auth()->id(),
         ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('news_photos', 'public');
            $news->update(['photo' => $photoPath]);
        }

         return redirect()->route('news.index');
    }

    public function show($id)
    {
        $news=News::findOrFail($id);
        $comments=$news->comment;
        $rating=$news->rating;



        return view('news.show', compact('news','comments', 'rating'));
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

    public function rating(Request $request, $id) {
        $request->validate([
            'grade' => 'required|integer|min:1|max:5',
        ]);

        $userId=auth()->id();

        $existingRating=Rating::where('news_id', $id)
            ->where('user_id', $userId)->first();

        if ($existingRating) {
            return redirect()->back()->withErrors(["Вы уже оценили эту новость"]);
        }

        Rating::create([
               'news_id' => $id,
               'user_id' => $userId,
               'grade' => $request->input('grade'),
            ]);

        $newRating=Rating::where('news_id', $id)->avg('grade');

        News::where('id', $id)->update(['rating' => $newRating]);



        return redirect()->back()->with('success', "Вы успешно оценили новость");
    }


}
