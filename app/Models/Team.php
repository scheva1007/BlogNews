<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function championships()
    {
        return $this->belongsToMany(Championship::class, 'teams_championship');
    }

    public function homeMatches()
    {
        return $this->hasMany(Schedule::class, 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(Schedule::class, 'away_team_id');
    }

    public function standings()
    {
        return $this->hasOne(Standing::class);
    }
}
