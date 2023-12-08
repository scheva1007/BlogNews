<?php

namespace Database\Seeders;

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

        DB::table('comments')->insert([
            [
                'content' => 'Отличные команды',
                'news_id' => 1,
                'user_id' => 1,
            ],

            [
                'content' => 'НБА-это сила',
                'news_id' => 2,
                'user_id' => 2,
            ],

            [
                'content' => 'Эдмонтон, Ванкувер',
                'news_id' => 3,
                'user_id' => 3,
            ],
        ]);
    }
}
