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
        $data = $service->updateStanding($request, $championshipId);

        return view('championship.standing', $data);
    }

    public function calendar(Request $request, $championshipId)
    {
        $selectSeason = $request->input('season', '2024-2025');

        $championship = Championship::findOrFail($championshipId);

        $seasonChampionship = Championship::where('name', $championship->name)
            ->where('season', $selectSeason)->first();

        $seasons = Championship::where('name', $championship->name)
            ->select('season')->distinct()->get();

        $matches = Schedule::where('championship_id', $seasonChampionship->id)
            ->orderByDesc('round')
            ->orderBy('match_date')
            ->get()->groupBy('round');

        return view('championship.calendar', compact('seasonChampionship', 'matches', 'seasons', 'selectSeason'));
    }
}
