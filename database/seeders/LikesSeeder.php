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
        DB::table('comment_likes')->insert([
            [
            'comment_id' => 1,
            'user_id' => 1,
            'like_status' => true,
            'created_at' => $timestamp,
            'updated_at'=>$timestamp,
            ],

            [
                'comment_id' => 2,
                'user_id' => 5,
                'like_status' => false,
                'created_at'=>$timestamp,
                'updated_at'=>$timestamp,
            ],

            [
                'comment_id' => 3,
                'user_id' => 2,
                'like_status' => false,
                'created_at'=>$timestamp,
                'updated_at'=>$timestamp,
            ],

            [
                'comment_id' => 4,
                'user_id' => 3,
                'like_status' => true,
                'created_at'=>$timestamp,
                'updated_at'=>$timestamp,
            ],

            [
                'comment_id' => 5,
                'user_id' => 4,
                'like_status' => true,
                'created_at'=>$timestamp,
                'updated_at'=>$timestamp,
            ],
        ]);
    }
}
