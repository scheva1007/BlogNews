<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('categories')->insert([
            ['name' => 'football'],
            ['name' => 'basketball'],
            ['name' => 'hockey'],
            ['name' => 'AutoMoto'],
            ['name' => 'box'],
        ]);
    }
}
