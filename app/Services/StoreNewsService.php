<?php

namespace App\Services;


use App\Http\Request\StoreNewsRequest;
use App\Models\News;
use Illuminate\Support\Facades\Cache;

class StoreNewsService
{
    public function create (StoreNewsRequest $request) {
        $news = News::create([
            'title' => $request->title,
            'text' => $request->text,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
            'published' => $request->has('published') ? true : false,
            'approved' => false,
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('news_photos', 'public');
            $news->update(['photo' => $photoPath]);
        }
        if ($request->has('tags')) {
            $tagIds = $request->input('tags');
            $news->tags()->sync($tagIds);
        }
        Cache::forget('latest_news');
        Cache::forget('top_news');
    }
}
