<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Request\StoreChampionshipRequest;
use App\Http\Request\StoreSeasonChampionshipRequest;
use App\Http\Request\StoreTeamChampionshipRequest;
use App\Models\Championship;
use App\Models\Schedule;
use App\Models\Standing;
use App\Models\Team;
use App\Models\TeamsChampionship;
use App\Services\StoreAdminService;
use Illuminate\Http\Request;

class ChampionshipController extends Controller
{
    public function standing(StoreAdminService $service, Request $request, $championshipId)
    {
        $season = $request->input('season');
        $data = $service->standingView($season, $championshipId);

        return view('championship.standing', $data);
    }

    public function calendar(Request $request, Championship $championship)
    {
        $lastSeason = Schedule::where('championship_id', $championship->id)
            ->orderByDesc('season')
            ->value('season');

        $selectSeason = $request->input('season', $lastSeason);

       $seasons = Schedule::where('championship_id', $championship->id)
           ->select('season')
           ->distinct()->get();

        $matches = Schedule::where('championship_id', $championship->id)
            ->where('season', $selectSeason)
            ->orderByDesc('round')
            ->orderBy('match_date')
            ->get()->groupBy('round');

        return view('championship.calendar', compact('championship', 'matches', 'seasons', 'selectSeason'));
    }

    public function creationTournaments()
    {
        return view('championship.creationTournaments');
    }

    public function createTeam()
    {
        return view('championship.createTeam');
    }

    public function storeTeam(StoreTeamChampionshipRequest $request)
    {
        $team = Team::create([
            'name' => $request->name,
            'country' => $request->country,
        ]);

        return redirect()->route('championship.creationTournaments');
    }

    public function createChampionship()
    {
        return view('championship.createChampionship');
    }

    public function storeChampionship(Request $request)
    {
        $championship = Championship::create([
            'name' => $request->name,
            'country' => $request->country,
        ]);

        return redirect()->route('championship.creationTournaments');
    }

    public function createSeason()
    {
        $championships = Championship::all();
        $teams = Team::all()->groupBy('country');

        return view('championship.createSeason', compact('championships', 'teams'));
    }

    public function storeSeason(StoreSeasonChampionshipRequest $request)
    {
        foreach (($request->teams) as $teamId) {
            Standing::updateOrCreate([
                'championship_id' => $request->championship_id,
                'season' => $request->season,
                'team_id' => $teamId
                ], [
                'matches' => 0,
                'wins' => 0,
                'draws' => 0,
                'losses' => 0,
                'goals_scored' => 0,
                'goals_missed' => 0,
                'points' => 0,
            ]);

            TeamsChampionship::firstOrCreate([
                'championship_id' => $request->championship_id,
                'team_id' => $teamId,
            ]);
        }

        return redirect()->route('championship.createSeason');
    }
}
