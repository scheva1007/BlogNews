<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Team_ChampionshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp=Carbon::now();

        DB::table('teams_championship')->insert([
            [
                'championship_id' => 1,
                'team_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 1,
                'team_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 1,
                'team_id' => 3,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 1,
                'team_id' => 4,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 1,
                'team_id' => 5,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 1,
                'team_id' => 6,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 1,
                'team_id' => 7,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 1,
                'team_id' => 8,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 2,
                'team_id' => 9,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 2,
                'team_id' => 10,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 2,
                'team_id' => 11,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 2,
                'team_id' => 12,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 2,
                'team_id' => 13,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 2,
                'team_id' => 14,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 2,
                'team_id' => 15,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'championship_id' => 2,
                'team_id' => 16,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ]);
    }
}
