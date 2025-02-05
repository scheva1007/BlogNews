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
                'text' => $faker->paragraph(5),
                'category_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 1,
                'rating' => 4.5,
                'photo' => 'news_photos/Cup.jpg',
                'published' => 1,
                'checked' => 1,
                'approved' => 1
            ],

            [
                'title' => 'NBA league',
                'text' => $faker->paragraph(5),
                'category_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 1,
                'rating' => 2.5,
                'photo' => 'news_photos/Basketball.jpg',
                'published' => 1,
                'checked' => 1,
                'approved' => 1
            ],

            [
                'title' => 'Stanley cup',
                'text' => $faker->paragraph(5),
                'category_id' => 3,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 2,
                'rating' => 5,
                'photo' => 'news_photos/Hockey.jpg',
                'published' => 1,
                'checked' => 1,
                'approved' => 1
            ],

            [
                'title' => 'All teams',
                'text' => $faker->paragraph(5),
                'category_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 2,
                'rating' => 0,
                'photo' => 'news_photos/football 1.jpg',
                'published' => 1,
                'checked' => 1,
                'approved' => 1
            ],

            [
                'title' => ' Champions of Ukraine',
                'text' => $faker->paragraph(5),
                'category_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 1,
                'rating' => 0,
                'photo' => 'news_photos/football 2.jpg',
                'published' => 1,
                'checked' => 1,
                'approved' => 1
            ],

            [
                'title' => 'Formula 1',
                'text' => $faker->paragraph(5),
                'category_id' => 4,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 2,
                'rating' => 0,
                'photo' => 'news_photos/Formula 1.jpg',
                'published' => 1,
                'checked' => 1,
                'approved' => 1
            ],

            [
                'title' => 'Evro 2024',
                'text' => $faker->paragraph(5),
                'category_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 2,
                'rating' => 0,
                'photo' => 'news_photos/football 1.jpg',
                'published' => 1,
                'checked' => 1,
                'approved' => 1
            ],

            [
                'title' => 'Mbappe moves to Real Madrid',
                'text' => $faker->paragraph(5),
                'category_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 1,
                'rating' => 0,
                'photo' => 'news_photos/Mbappe.jpg',
                'published' => 1,
                'checked' => 1,
                'approved' => 1
            ],

            [
                'title' => 'Florida and Edmonton will determine the winner',
                'text' => $faker->paragraph(5),
                'category_id' => 3,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 2,
                'rating' => 0,
                'photo' => 'news_photos/Cup Stanley.jpg',
                'published' => 1,
                'checked' => 1,
                'approved' => 1
            ],

            [
                'title' => 'Usik is the absolute champion',
                'text' => $faker->paragraph(5),
                'category_id' => 4,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'user_id' => 2,
                'rating' => 0,
                'photo' => 'news_photos/Box.jpg',
                'published' => 1,
                'checked' => 1,
                'approved' => 1
            ],
        ]);
    }
}
