<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@sanita.com',
            'password' => Hash::make('password'),
            'cancelled' => 0,
            'remember_token' => \Illuminate\Support\Str::random(60),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
