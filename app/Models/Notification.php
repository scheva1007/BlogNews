<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function news ()
    {
        return $this->belongsTo(News::class);
    }

    public  function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
