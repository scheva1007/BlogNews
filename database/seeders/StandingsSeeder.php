<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StandingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = Carbon::now();
        $standings = [];

        $championships = DB::table('championships')->get();

        foreach ($championships as $championship) {
            $teams = DB::table('teams')->where('country_id', $championship->country_id)->pluck('id')->toArray();
            $matches = rand(15, 20);

            foreach ($teams as $teamId) {
                $wins = rand(0, $matches);
                $remaining = $matches - $wins;
                $draws = rand(0, $remaining);
                $losses = $remaining - $draws;
                $points = ($wins * 3) + ($draws * 1);
                $goals_scored = rand($wins * 1, $wins * 3 + $draws * 2);
                $goals_missed = rand($losses * 1, $losses * 3 + $draws * 2);

                $standings[] = [
                    'championship_id' => $championship->id,
                    'team_id' => $teamId,
                    'matches' => $matches,
                    'wins' => $wins,
                    'draws' => $draws,
                    'losses' => $losses,
                    'goals_scored' => $goals_scored,
                    'goals_missed' => $goals_missed,
                    'points' => $points,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }
        }

        DB::table('standings')->insert($standings);
    }
}
