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

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d.m.Y, H:m');
    }

    public function getCommentCountAttribute()
    {
        return $this->comment()->count();
    }

}
