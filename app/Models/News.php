<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d.m.Y, H:m');
    }

    public function getCommentCountAttribute()
    {
        return $this->comment()->count();
    }

    public function userRating()
    {
        $userId = auth()->id();
        $rating = Rating::where('news_id', $this->id)
            ->where('user_id', $userId)
            ->first();

        return $rating ? $rating->grade : null;
    }
}
