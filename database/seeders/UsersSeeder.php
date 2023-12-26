<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        $timestamp=Carbon::now();
        DB::table('users')->insert([
            [
                'name' => 'Alex',
                'email' => 'Alex@ukr.net',
                'role' => 'admin',
                'password' => Hash::make('123123123'),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'name' => 'Sem',
                'email' => 'Sem@ukr.net',
                'role' => 'author',
                'password' => Hash::make('456456456'),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'name' => 'Jhon',
                'email' => 'Jhon@ukr.net',
                'role' => 'registered',
                'password' => Hash::make('789789789'),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'name' => 'Yulia',
                'email' => 'Yulia@ukr.net',
                'role' => 'registered',
                'password' => Hash::make('135135135'),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],

            [
                'name' => 'Bella',
                'email' => 'Bella@ukr.net',
                'role' => 'registered',
                'password' => Hash::make('246246246'),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ]);
    }
}
