<?php

namespace App\Commands;

use App\Http\Request\UpdateNewsRequest;
use App\Models\News;

class UpdateNewsCommand
{
    public function execute (UpdateNewsRequest $request, News $news) {
     $news->update([
            'title' => $request->title,
            'content' => $request->text,
            'category_id' => $request->category_id,
            'photo' => $request->hasFile('photo') ? $request->file('photo')->store('news_photos', 'public') : $news->photo,
        ]);
     if($request->has('tags')) {
         $tagIds = $request->input('tags');
         $news->tags()->sync($tagIds);
      }
    }
}
