<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Request\UpdateCabinetRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonaCabinetApiController extends Controller
{
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

        return response()->json($user, 200);
    }

    public function myPublication()
    {
        $user = auth()->user();
        $news = $user->news()
            ->where('checked', true)
            ->where('approved', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($news, 200);
    }

    public function myUnapprovedNews()
    {
        $user = auth()->user();
        $news = $user->news()
            ->where('published', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($news, 200);
    }

    public function myRejectionNews()
    {
        $user = auth()->user();
        $rejectionNews = $user->news()
            ->where('checked', true)
            ->where('approved', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($rejectionNews, 200);
    }

    public function updateUnapprovedNews(Request $request, News $news)
    {
        $news->update([
            'title' => $request->title,
            'content' => $request->text,
            'category_id' => $request->category_id,
            'photo' => $request->hasFile('photo') ? $request->file('photo')->store('news_photos', 'public') : $news->photo,
            'published' => $request->boolean('published'),
        ]);
        if ($request->has('tags')) {
            $tagIds = $request->input('tags');
            $news->tags()->sync($tagIds);
        }

        return response()->json($news, 200);
    }
}
