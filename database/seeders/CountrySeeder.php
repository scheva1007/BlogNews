<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp=Carbon::now();

        DB::table('countries')->insert([
               ['name' => 'Англія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
               ],

               ['name' => 'Іспанія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
               ],
        ]);
    }
}
