<?php

namespace App\Commands;

use App\Http\Request\RatingNewsRequest;
use App\Models\Rating;

class RatingNewsCommand
{
    public function execute (RatingNewsRequest $request, $newsId, $userId)
    {
         Rating::create([
            'news_id' => $newsId,
            'user_id' => $userId,
            'grade' => $request->input('grade'),
        ]);
    }
}
