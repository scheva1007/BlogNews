<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        $timestamp=Carbon::now();
        DB::table('news')->insert([
            [
                'title' => 'Championship',
                'content' => 'Real, Barsa',
                'category_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'title' => 'NBA league',
                'content' => 'Grea clubs',
                'category_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'title' => 'Stanley cup',
                'content' => 'legendary clubs',
                'category_id' => 3,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'title' => 'All teams',
                'content' => 'Mercedes, Red Bull',
                'category_id' => 4,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'title' => ' Champions of Ukraine',
                'content' => 'Dynamo, Shakhtar',
                'category_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'title' => 'world champions',
                'content' => 'Hamilton, Verstappen, Schumacher',
                'category_id' => 4,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ]);
    }
}
