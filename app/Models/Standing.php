<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function championships()
    {
        return $this->belongsTo(Championship::class);
    }

    public function teams()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
