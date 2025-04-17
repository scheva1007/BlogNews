<?php

namespace App\Services;


use App\Http\Request\StoreAdminRequest;
use App\Models\Championship;
use App\Models\Schedule;
use App\Models\Standing;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StoreAdminService
{
    public function create(StoreAdminRequest $request)
    {

        $match = Schedule::create([
            'championship_id' => $request->championship_id,
            'season' => $request->season,
            'round' => $request->round,
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'home_score' => $request->home_score,
            'away_score' => $request->away_score,
            'match_date' => $request->match_date,
            'status' => $request->status,
        ]);

        $teams = [$match->home_team_id, $match->away_team_id];
        $championshipId = $match->championship_id;

        foreach ($teams as $teamId) {
            $exists = DB::table('teams_championship')
                ->where('team_id', $teamId)
                ->where('championship_id', $championshipId)
                ->exists();

            if (!$exists) {
                DB::table('teams_championship')->insert([
                    'team_id' => $teamId,
                    'championship_id' => $championshipId,
                ]);
            }
        }
        if ($match->status === 'finished') {
        $this->updateStanding($match->season, $championshipId);
        }

        return $match;
    }

    public function updateStanding($season, $championshipId)
    {
        $matches = Schedule::where('season', $season)
            ->where('championship_id', $championshipId)->get();

        $standings = [];

        foreach ($matches as $match) {
            $homeId = $match->home_team_id;
            $awayId = $match->away_team_id;
            $homeScore = $match->home_score;
            $awayScore = $match->away_score;

        foreach ([$homeId, $awayId] as $teamId) {
                if (!isset($standings[$teamId])) {
                    $standings[$teamId] = [
                        'matches' => 0,
                        'wins' => 0,
                        'draws' => 0,
                        'losses' => 0,
                        'goals_scored' => 0,
                        'goals_missed' => 0,
                        'points' => 0,
                        'championship_id' => $championshipId,
                        'season' => $season,
                        'team_id' => $teamId
                    ];
                }
        }
        $standings[$homeId]['matches']++;
        $standings[$awayId]['matches']++;

        $standings[$homeId]['goals_scored'] += $homeScore;
        $standings[$homeId]['goals_missed'] += $awayScore;

        $standings[$awayId]['goals_scored'] += $awayScore;
        $standings[$awayId]['goals_missed'] += $homeScore;

        if ($homeScore > $awayScore) {
            $standings[$homeId]['wins']++;
            $standings[$homeId]['points'] += 3;
            $standings[$awayId]['losses']++;
        } elseif ($homeScore < $awayScore) {
            $standings[$awayId]['wins']++;
            $standings[$awayId]['points'] += 3;
            $standings[$homeId]['losses']++;
        } else {
            $standings[$homeId]['draws']++;
            $standings[$awayId]['draws']++;
            $standings[$homeId]['points']++;
            $standings[$awayId]['points']++;
        }
    }

    // Очистити старі записи
        Standing::where('season', $season)
        ->where('championship_id', $championshipId)
        ->delete();

    // Зберегти нові
        foreach ($standings as $data) {
        Standing::create($data);
    }

        $standings = Standing::where('season', $season)
            ->where('championship_id', $championshipId)
            ->with('teams')
            ->orderByDesc('points')
            ->orderByDesc('wins')
            ->get();
    }

    public function standingView($season, $championshipId)
   {
       if (!$season) {
           $season = Schedule::where('championship_id', $championshipId)
               ->orderByDesc('season')
               ->value('season');
       }
        $this->updateStanding($season, $championshipId);
        $standings = Standing::where('season', $season)
            ->where('championship_id', $championshipId)
            ->with('teams')
            ->orderByDesc('points')
            ->orderByDesc('wins')->get();

       $seasonChampionship = Championship::find($championshipId);
       $seasons = Standing::where('championship_id', $championshipId)
           ->select('season')
           ->distinct()->get();

       return [
           'season' => $season,
           'championshipId' => $championshipId,
           'standings' => $standings,
           'seasonChampionship' => $seasonChampionship,
           'seasons' => $seasons,
           'selectedSeason' => $season,
       ];
   }
}
