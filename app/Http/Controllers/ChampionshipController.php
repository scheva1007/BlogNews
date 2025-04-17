<?php

namespace App\Http\Controllers;

use App\Http\Request\StoreAdminRequest;
use App\Models\Championship;
use App\Models\Schedule;
use App\Models\Standing;
use App\Models\Team;
use App\Services\StoreAdminService;
use Illuminate\Http\Request;
use function PHPUnit\Framework\matches;

class ChampionshipController extends Controller
{
    public function standing(StoreAdminService $service, Request $request, $championshipId)
    {
        $season = $request->input('season');
        $data = $service->standingView($season, $championshipId);

        return view('championship.standing', $data);
    }

    public function calendar(Request $request, $championshipId)
    {
        $selectSeason = $request->input('season', '2024-2025');

        $championship = Championship::findOrFail($championshipId);

       $seasons = Schedule::where('championship_id', $championshipId)
           ->select('season')
           ->distinct()->get();

        $matches = Schedule::where('championship_id', $championshipId)
            ->where('season', $selectSeason)
            ->orderByDesc('round')
            ->orderBy('match_date')
            ->get()->groupBy('round');

        return view('championship.calendar', compact('championship', 'matches', 'seasons', 'selectSeason'));
    }
}
