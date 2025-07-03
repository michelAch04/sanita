<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['description' => 'Pending',     'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Processing',  'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Shipped',     'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Delivered',   'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Cancelled',   'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
