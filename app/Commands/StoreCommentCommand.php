<?php
//
//namespace App\Commands;
//
//use App\Http\Request\StoreCommentRequest;
//use App\Models\Comment;
//use App\Models\News;
//
//class StoreCommentCommand
//{
//    public function execute(StoreCommentRequest $request, News $news, $user)
//    {
//        $comment = Comment::create([
//            'news_id' => $news->id,
//            'content' => $request->text,
//            'user_id' => $user->id,
//        ]);
//
//        return $comment;
//   }
//}
