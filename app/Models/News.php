<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tag');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d.m.Y, H:m');
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
