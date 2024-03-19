<?php


namespace App\Commands;


use App\Http\Request\StoreCommentRequest;
use App\Models\News;


class StoreCommentCommand
{
    public function execute (StoreCommentRequest $request, News $news, $user) {
        $comment=$news->comment()->create([
            'content' => $request->text,
            'user_id' => $user->id,
        ]);
        return $comment;
    }
}
