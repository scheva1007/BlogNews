<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Championship extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'teams_championship');
    }

    public function matches()
    {
        return $this->hasMany(Schedule::class);
    }

    public function standings()
    {
        return $this->hasMany(Standing::class);
    }
}
