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
                'country' => 'Англія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Ліверпуль',
                'country' => 'Англія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Челсі',
                'country' => 'Англія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Манчестер Сіті',
                'country' => 'Англія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Астон Вілла',
                'country' => 'Англія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Нотінгем Форрест',
                'country' => 'Англія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Тоттенхем',
                'country' => 'Англія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Борнмут',
                'country' => 'Англія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Барселона',
                'country' => 'Іспанія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Реал',
                'country' => 'Іспанія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Атлетіко',
                'country' => 'Іспанія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Атлетік',
                'country' => 'Іспанія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Жирона',
                'country' => 'Іспанія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Валенсія',
                'country' => 'Іспанія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Мальорка',
                'country' => 'Іспанія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],

            [
                'name' => 'Сельта',
                'country' => 'Іспанія',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ]);
    }
}
