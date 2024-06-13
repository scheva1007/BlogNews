<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class News_TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news_tag')->insert([
            [
                'news_id' => 1,
                'tag_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
            'news_id' => 1,
            'tag_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ],

        [
                'news_id' => 1,
                'tag_id' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],

        [
            'news_id' => 2,
            'tag_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ],

        [
                'news_id' => 3,
                'tag_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],

        [
            'news_id' => 6,
            'tag_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ],

            [
                'news_id' => 10,
                'tag_id' => 11,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'news_id' => 6,
                'tag_id' => 9,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'news_id' => 8,
                'tag_id' => 13,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'news_id' => 7,
                'tag_id' => 13,
                'created_at' => now(),
                'updated_at' => now()
            ],

        ]);
    }
}
