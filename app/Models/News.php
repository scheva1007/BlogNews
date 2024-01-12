<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
//    protected $dates = ['created_at', 'updated_at'];
    protected $guarded=[];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function rating() {
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

    public function averageRating()
    {
        $ratings = session('news_ratings.' . $this->id, []);
        return count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;
    }

    public function userRating()
    {
        $userId = auth()->id();
        return session("news_ratings.{$this->id}.{$userId}", null);
    }

    public function updateRating($rating)
    {
        $userId = auth()->id();

        session(["news_ratings.{$this->id}.{$userId}" => $rating]);

        $ratings = session("news_ratings.{$this->id}", []);
        $ratings[$userId] = $rating;
        session(["news_ratings.{$this->id}" => $ratings]);
    }

}
