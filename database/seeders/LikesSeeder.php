<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp=Carbon::now();
        DB::table('likes')->insert([
            [
            'comment_id' => 1,
            'user_id' => 1,
            'likes' => 1,
            'dislikes' => 0,
            'created_at'=>$timestamp,
            'updated_at'=>$timestamp,
            ],

            [
                'comment_id' => 2,
                'user_id' => 5,
                'likes' => 1,
                'dislikes' => 0,
                'created_at'=>$timestamp,
                'updated_at'=>$timestamp,
            ],

            [
                'comment_id' => 3,
                'user_id' => 2,
                'likes' => 1,
                'dislikes' => 0,
                'created_at'=>$timestamp,
                'updated_at'=>$timestamp,
            ],

            [
                'comment_id' => 4,
                'user_id' => 3,
                'likes' => 1,
                'dislikes' => 0,
                'created_at'=>$timestamp,
                'updated_at'=>$timestamp,
            ],

            [
                'comment_id' => 5,
                'user_id' => 4,
                'likes' => 0,
                'dislikes' => 1,
                'created_at'=>$timestamp,
                'updated_at'=>$timestamp,
            ],
        ]);
    }
}
