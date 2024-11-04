<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Request\UpdateCabinetRequest;
use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonalCabinetController extends Controller
{
    public function index()
    {

        return view('cabinet.index');
    }

    public function edit()
    {

        return view('cabinet.edit');
    }

    public function update(UpdateCabinetRequest $request)
    {
        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('cabinet.edit', $user->id);
    }

    public function myPublication()
    {
        $user = auth()->user();
        $news = $user->news()
            ->where('checked', true)
            ->where('approved', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cabinet.publications', compact('news'));
    }

    public function myUnapprovedNews($userId)
    {
        $news = News::where('user_id', $userId)
            ->where(function ($query) {
                $query->where('published', false);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('cabinet.unapprovedNews', compact('news'));
    }

    public function myRejectionNews($userId)
    {
        $rejectionNews = News::where('user_id', $userId)
            ->where(function  ($query) {
                $query->where('checked', true)
                    ->where('approved', false);
        })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('cabinet.rejectionNews', compact('rejectionNews'));
    }

    public function editUnapprovedNews($newsId)
    {
        $news = News::where('id', $newsId)->where('approved', false)->firstOrFail();
        $categories = Category::all();
        $tags = Tag::all();

       return view('cabinet.editUnapprovedNews', compact('news', 'categories', 'tags'));
    }

    public function updateUnapprovedNews(Request $request, $newsId)
    {
        $news = News::findOrFail($newsId);
        $news->update([
            'title' => $request->title,
            'content' => $request->text,
            'category_id' => $request->category_id,
            'photo' => $request->hasFile('photo') ? $request->file('photo')->store('news_photos', 'public') : $news->photo,
            'published' => $request->boolean('published'),
            'checked' => false,
            'approved' => false,
        ]);
        if($request->has('tags')) {
            $tagIds = $request->input('tags');
            $news->tags()->sync($tagIds);
        }

        return redirect()->route('cabinet.unapprovedNews', ['userId' => auth()->id()]);
    }
}
