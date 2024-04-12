<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);

        $timestamp=Carbon::now();
        DB::table('news')->insert([
            [
                'title' => 'Championship',
                'content' => $faker->paragraph(5),
                'category_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 1,
                'rating' => 4.5,
                'photo' => 'news_photos/football 1.jpg'
            ],

            [
                'title' => 'NBA league',
                'content' => $faker->paragraph(5),
                'category_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 1,
                'rating' => 2.5,
                'photo' => 'news_photos/NBA.jpg'
            ],

            [
                'title' => 'Stanley cup',
                'content' => $faker->paragraph(5),
                'category_id' => 3,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 2,
                'rating' => 5,
                'photo' => 'news_photos/NHL.jpg'
            ],

            [
                'title' => 'All teams',
                'content' => $faker->paragraph(5),
                'category_id' => 4,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 2,
                'rating' => 0,
                'photo' => 'news_photos/football 2.jpg'
            ],

            [
                'title' => ' Champions of Ukraine',
                'content' => $faker->paragraph(5),
                'category_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 1,
                'rating' => 0,
                'photo' => 'news_photos/football 3.jpg'
            ],

            [
                'title' => 'world champions',
                'content' => $faker->paragraph(5),
                'category_id' => 4,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 2,
                'rating' => 0,
                'photo' => 'news_photos/Cup 1.jpg'
            ],
        ]);
    }
}
