<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $model = Tag::class;

    public function run()
    {
        DB::table('tags')->insert([
            [
              'name' => 'Ліга Чемпіонів',
              'created_at' => now(),
              'updated_at' => now()
            ],

        [
              'name' => 'Футбол',
              'created_at' => now(),
              'updated_at' => now()
        ],

            [
                'name' => 'Хокей',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Баскетбол',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Формула-1',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Шахтар',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Фінал',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Вінісіус',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Хемілтон',
                'created_at' => now(),
                'updated_at' => now()
            ],

        ]);
    }
}
