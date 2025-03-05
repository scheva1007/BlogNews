<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\Schedule;
use App\Models\Standing;
use function PHPUnit\Framework\matches;

class ChampionshipController extends Controller
{
    public function standing($championshipId)
    {
        $championship = Championship::findOrFail($championshipId);
        $standings = Standing::where('championship_id', $championshipId)
            ->with('teams')->orderByDesc('points')->get();

        return view('championship.standing', compact('championship', 'standings'));
    }

    public function calendar($championshipId)
    {
        $championship = Championship::findOrFail($championshipId);
        $matches = Schedule::where('championship_id', $championshipId)
            ->orderByDesc('round')
            ->orderBy('match_date')
            ->get()->groupBy('round');

        return view('championship.calendar', compact('championship', 'matches'));
    }
}
