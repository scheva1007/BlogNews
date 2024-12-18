<?php

namespace App\Services;

use App\Http\Request\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Support\Facades\Cache;

class UpdateNewsService
{
    public function execute (UpdateNewsRequest $request, News $news) {
        $news->update([
            'title' => $request->title,
            'content' => $request->text,
            'category_id' => $request->category_id,
            'photo' => $request->hasFile('photo') ? $request->file('photo')->store('news_photos', 'public') : $news->photo,
            'published' => $request->has('published') ? true : false,
        ]);
        if($request->has('tags')) {
            $tagIds = $request->input('tags');
            $news->tags()->sync($tagIds);
        }
        Cache::forget('latest_news');
        Cache::forget('top_news');
    }
}



