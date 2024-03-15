<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded=[];

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d.m.Y');
    }
}
