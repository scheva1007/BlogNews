<?php

namespace App\Services;


use App\Http\Request\StoreNewsRequest;
use App\Models\News;

class StoreNewsService
{
    public function execute (StoreNewsRequest $request) {
        $news = News::create([
            'title' => $request->title,
            'content' => $request->text,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('news_photos', 'public');
            $news->update(['photo' => $photoPath]);
        }
        if ($request->has('tags')) {
            $tagIds = $request->input('tags');
            $news->tags()->sync($tagIds);
        }
    }
}
