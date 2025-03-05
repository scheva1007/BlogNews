<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            CategoriesSeeder::class,
            NewsSeeder::class,
            CommentsSeeder::class,
            RatingsSeeder::class,
            LikesSeeder::class,
            TagSeeder::class,
            News_TagSeeder::class,
            TeamSeeder::class,
            ChampionshipSeeder::class,
            Team_ChampionshipSeeder::class,
            ScheduleSeeder::class,
            StandingsSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
