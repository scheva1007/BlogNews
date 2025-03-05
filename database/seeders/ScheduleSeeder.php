<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp=Carbon::now();

        DB::table('schedule')->insert([
          [
            'championship_id' => 1,
            'round' => 1,
            'home_team_id' => 1,
            'away_team_id' => 2,
            'home_score' => 0,
            'away_score' => 2,
            'match_date' => Carbon::parse('2025-02-01 19:00:00'),
            'status' => 'finished',
            'created_at' => $timestamp,
            'updated_at' => $timestamp
           ],

            [
                'championship_id' => 2,
                'round' => 1,
                'home_team_id' =>9,
                'away_team_id' => 11,
                'home_score' => 4,
                'away_score' => 1,
                'match_date' => Carbon::parse('2025-02-5 15:00:00'),
                'status' => 'finished',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 1,
                'round' => 1,
                'home_team_id' => 3,
                'away_team_id' => 4,
                'home_score' => 1,
                'away_score' => 2,
                'match_date' => Carbon::parse('2025-01-11 18:00:00'),
                'status' => 'finished',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 2,
                'round' => 1,
                'home_team_id' => 10,
                'away_team_id' => 12,
                'home_score' => 0,
                'away_score' => 1,
                'match_date' => Carbon::parse('2025-02-12 21:00:00'),
                'status' => 'finished',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 1,
                'round' => 1,
                'home_team_id' => 5,
                'away_team_id' => 6,
                'home_score' => 2,
                'away_score' => 1,
                'match_date' => Carbon::parse('2025-02-01 17:00:00'),
                'status' => 'finished',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 1,
                'round' => 2,
                'home_team_id' => 7,
                'away_team_id' => 8,
                'home_score' => 3,
                'away_score' => 1,
                'match_date' => Carbon::parse('2025-02-08 20:00:00'),
                'status' => 'finished',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 2,
                'round' => 2,
                'home_team_id' => 13,
                'away_team_id' => 14,
                'home_score' => 1,
                'away_score' => 0,
                'match_date' => Carbon::parse('2025-01-16 19:00:00'),
                'status' => 'finished',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 1,
                'round' => 2,
                'home_team_id' => 5,
                'away_team_id' => 3,
                'home_score' => 0,
                'away_score' => 3,
                'match_date' => Carbon::parse('2025-02-15 18:00:00'),
                'status' => 'finished',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 2,
                'round' => 2,
                'home_team_id' => 9,
                'away_team_id' => 14,
                'home_score' => 4,
                'away_score' => 2,
                'match_date' => Carbon::parse('2025-02-14 22:00:00'),
                'status' => 'finished',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 1,
                'round' => 2,
                'home_team_id' => 2,
                'away_team_id' => 6,
                'home_score' => null,
                'away_score' => null,
                'match_date' => Carbon::parse('2025-03-11 21:00:00'),
                'status' => 'scheduled',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
         ]);
    }
}
