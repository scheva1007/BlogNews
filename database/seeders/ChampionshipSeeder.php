<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChampionshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp=Carbon::now();

        DB::table('championships')->insert([
            [
                'name' => 'АПЛ',
                'season' => '2024/2025',
                'country_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Ла Ліга',
                'season' => '2024/2025',
                'country_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ]);
    }
}
