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
        $this->updateStanding($request, $championshipId);
    }
    }

    public function updateStanding(Request $request, $championshipId)
    {
        $selectedSeason = $request->input('season', '2024-2025');

        $championship = Championship::findOrFail($championshipId);
        $seasonChampionship = Championship::where('name', $championship->name)
            ->where('season', $selectedSeason)->first();

        $seasons = Championship::where('name', $championship->name)
            ->select('season')->distinct()->get();

        $teams = Team::whereHas('championships', function ($query) use ($seasonChampionship) {
            $query->where('championship_id', $seasonChampionship->id);
        })->get();

        foreach ($teams as $team) {
            $matchPlay = Schedule::where('championship_id', $seasonChampionship->id)
                ->where(function ($query) use ($team) {
                    $query->where('home_team_id', $team->id)
                        ->orWhere('away_team_id', $team->id);
                })
                ->where('status', 'finished')->get();

            $wins = 0;
            $draws = 0;
            $losses = 0;
            $goalsScored = 0;
            $goalsMissed = 0;
            $points = 0;

            foreach ($matchPlay as $match) {
                if ($match->home_team_id == $team->id) {
                    $goalsScored += $match->home_score;
                    $goalsMissed += $match->away_score;
                    if ($match->home_score > $match->away_score) {
                        $wins++;
                        $points+=3;
                    } elseif ($match->home_score ==$match->away_score) {
                        $draws++;
                        $points+=1;
                    } else {
                        $losses++;
                    }
                } else {
                    $goalsScored += $match->away_score;
                    $goalsMissed += $match->home_score;
                    if ($match->away_score > $match->home_score) {
                        $wins++;
                        $points +=3;
                    } elseif ($match->away_score == $match->home_score) {
                        $draws++;
                        $points +=1;
                    } else {
                        $losses++;
                    }
                }
            }

            $standingsRecord = Standing::updateOrCreate([
                'championship_id' => $seasonChampionship->id,
                'team_id' => $team->id,
            ]);

            $standingsRecord->matches = $matchPlay->count();
            $standingsRecord->wins = $wins;
            $standingsRecord->draws = $draws;
            $standingsRecord->losses = $losses;
            $standingsRecord->goals_scored = $goalsScored;
            $standingsRecord->goals_missed = $goalsMissed;
            $standingsRecord->points = $points;
            $standingsRecord->save();
        }

        $standings = Standing::where('championship_id', $seasonChampionship->id)
            ->with('teams')
            ->orderByDesc('points')
            ->orderByDesc('wins')->get();

        return compact('seasonChampionship', 'standings', 'seasons', 'selectedSeason');
    }
}
