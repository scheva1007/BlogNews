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
            ],

            [
                'content' => 'НБА-это сила',
                'news_id' => 2,
                'user_id' => 3,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'content' => 'Эдмонтон, Ванкувер',
                'news_id' => 3,
                'user_id' => 4,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'content' => 'yes I agree',
                'news_id' => 2,
                'user_id' => 5,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'content' => 'Mercedes must catch up with Red Bull',
                'news_id' => 4,
                'user_id' => 5,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ]);
    }
}
