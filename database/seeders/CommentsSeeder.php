<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp=Carbon::now();
        DB::table('comments')->insert([
            [
                'content' => 'Отличные команды',
                'news_id' => 1,
                'user_id' => 3,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'countLikes' => 5,
                'countDislikes' => 0,
            ],

            [
                'content' => 'НБА-это сила',
                'news_id' => 2,
                'user_id' => 3,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'countLikes'  => 14,
                'countDislikes' => 2,
            ],

            [
                'content' => 'Эдмонтон, Ванкувер',
                'news_id' => 3,
                'user_id' => 4,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'countLikes'  => 10,
                'countDislikes' => 0,
            ],

            [
                'content' => 'yes I agree',
                'news_id' => 2,
                'user_id' => 5,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'countLikes'  => 11,
                'countDislikes' => 1,
            ],

            [
                'content' => 'Mercedes must catch up with Red Bull',
                'news_id' => 4,
                'user_id' => 5,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'countLikes'  => 5,
                'countDislikes' => 0,
            ],
        ]);
    }
}
