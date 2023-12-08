<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Alex',
                'email' => 'Alex@ukr.net',
                'password' => Hash::make('123123123'),
            ],

            [
                'name' => 'Sem',
                'email' => 'Sem@ukr.net',
                'password' => Hash::make('456456456'),
            ],

            [
                'name' => 'Jhon',
                'email' => 'Jhon@ukr.net',
                'password' => Hash::make('789789789'),
            ],
        ]);
    }
}
