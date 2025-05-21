<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['user_id' => 1,  'view' => 1, 'created_at' => now(), 'updated_at' => now()],

        ];

        DB::table('permissions')->insert($permissions);
    }
}
