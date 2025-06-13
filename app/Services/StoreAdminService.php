<?php

namespace App\Services;


use App\Http\Request\StoreAdminRequest;
use App\Models\Championship;
use App\Models\Schedule;
use App\Models\Standing;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use function PHPUnit\Framework\matches;

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
            'status' =>$request->status,
        ]);

        if ($match->status === 'finished') {
            $this->updateStanding($match);
        }

        return $match;
    }

    public function updateStanding(Schedule $match)
    {
       $season = $match->season;
       $championshipId = $match->championship_id;
       $teamsId = [$match->home_team_id, $match->away_team_id];

       foreach ($teamsId as $item) {
           $matches = Schedule::where('season', $season)
               ->where('championship_id', $championshipId)
               ->where('status', 'finished')
               ->where(function ($query) use ($item) {
                   $query->where('home_team_id', $item)
                       ->orWhere('away_team_id', $item);
               })->get();

           $standing = [
               'matches' => 0,
               'wins' => 0,
               'draws' => 0,
               'losses' => 0,
               'goals_scored' => 0,
               'goals_missed' => 0,
               'points' => 0,
               'championship_id' => $championshipId,
               'season' => $season,
               'team_id' => $item,
           ];

           foreach ($matches as $match) {
               $homeTeam = $match->home_team_id == $item;
               $homeGoals = $homeTeam ? $match->home_score : $match->away_score;
               $awayGoals = $homeTeam ? $match->away_score : $match->home_score;

               $standing['matches'] ++;
               $standing['goals_scored'] += $homeGoals;
               $standing['goals_missed'] += $awayGoals;

               if ($homeGoals > $awayGoals) {
                   $standing['wins'] ++;
                   $standing['points'] += 3;
               } elseif ($homeGoals < $awayGoals) {
                   $standing['losses'] ++;
               } else {
                   $standing['draws'] ++;
                   $standing['points'] += 1;
               }
           }
           Standing::updateOrCreate(
               [
                   'season' => $season,
                   'championship_id' => $championshipId,
                   'team_id' => $item,
               ],
               $standing
           );
       }
    }

    public function standingView($season, $championshipId)
    {
        if (!$season) {
            $season = Schedule::where('championship_id', $championshipId)
                ->orderByDesc('season')
                ->value('season');
        }

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

    public function updateStandingAfterDelete($season, $championshipId, $teamsId)
    {
        foreach ($teamsId as $teamId) {
            $matches = Schedule::where('season', $season)
                ->where('championship_id', $championshipId)
                ->where('status', 'finished')
                ->where(function ($query) use ($teamId) {
                    $query->where('home_team_id', $teamId)
                        ->orWhere('away_team_id', $teamId);
                })->get();

            $standing = [
                'matches' => 0,
                'wins' => 0,
                'draws' => 0,
                'losses' => 0,
                'goals_scored' => 0,
                'goals_missed' => 0,
                'points' => 0,
                'championship_id' => $championshipId,
                'season' => $season,
                'team_id' => $teamId,
            ];

            foreach ($matches as $match) {
                $homeTeam = $match->home_team_id == $teamId;
                $homeGoals = $homeTeam ? $match->home_score : $match->away_score;
                $awayGoals = $homeTeam ? $match->away_score : $match->home_score;

                $standing['matches']++;
                $standing['goals_scored'] += $homeGoals;
                $standing['goals_missed'] += $awayGoals;

                if ($homeGoals > $awayGoals) {
                    $standing['wins']++;
                    $standing['points'] += 3;
                } elseif ($homeGoals < $awayGoals) {
                    $standing['losses']++;
                } else {
                    $standing['draws']++;
                    $standing['points'] += 1;
                }
            }

            Standing::updateOrCreate(
                [
                    'season' => $season,
                    'championship_id' => $championshipId,
                    'team_id' => $teamId,
                ],
                $standing
            );
        }
    }
}
