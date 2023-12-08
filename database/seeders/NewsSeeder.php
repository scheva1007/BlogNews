<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news')->insert([
            [
                'title' => 'Championship',
                'content' => 'Real, Barsa',
                'category_id' => 1,
            ],

            [
                'title' => 'NBA league',
                'content' => 'Grea clubs',
                'category_id' => 2,
            ],

            [
                'title' => 'Stanley cup',
                'content' => 'legendary clubs',
                'category_id' => 3,
            ],

            [
                'title' => 'All teams',
                'content' => 'Mercedes, Red Bull',
                'category_id' => 4,
            ],
        ]);
    }
}
