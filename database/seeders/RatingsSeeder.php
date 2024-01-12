<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Carbon\PHPStan\AbstractMacro;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp=Carbon::now();
        DB::table('ratings')->insert([
            [
            'news_id'=>1,
            'grade'=>4,
            'user_id'=>3,
            'created_at'=>$timestamp,
            'updated_at'=>$timestamp,
            ],

            [
                'news_id'=>2,
                'grade'=>3,
                'user_id'=>1,
                'created_at'=>$timestamp,
                'updated_at'=>$timestamp,
            ],

            [
                'news_id'=>1,
                'grade'=>5,
                'user_id'=>2,
                'created_at'=>$timestamp,
                'updated_at'=>$timestamp,
            ],

            [
                'news_id'=>2,
                'grade'=>2,
                'user_id'=>4,
                'created_at'=>$timestamp,
                'updated_at'=>$timestamp,
            ],

            [
                'news_id'=>3,
                'grade'=>5,
                'user_id'=>4,
                'created_at'=>$timestamp,
                'updated_at'=>$timestamp,
            ],

        ]);
    }
}
