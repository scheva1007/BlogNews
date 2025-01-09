<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public  function replies ()
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('status', 'verified');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d.m.Y');
    }
}
