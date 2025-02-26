<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = Carbon::now();

        DB::table('teams')->insert([
            [
                'name' => 'Арсенал',
                'country_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Ліверпуль',
                'country_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Челсі',
                'country_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Манчестер Сіті',
                'country_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Астон Вілла',
                'country_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Нотінгем Форрест',
                'country_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Тоттенхем',
                'country_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Борнмут',
                'country_id' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Барселона',
                'country_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Реал',
                'country_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Атлетіко',
                'country_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Атлетік',
                'country_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Жирона',
                'country_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Валенсія',
                'country_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Мальорка',
                'country_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Сельта',
                'country_id' => 2,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ]);
    }
}
