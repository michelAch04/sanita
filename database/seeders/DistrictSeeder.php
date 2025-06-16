<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        // Assuming governorate IDs 1 = Beqaa, 2 = Akkar, etc.
        DB::table('districts')->insert([
            ['governorate_id' => 1, 'name_en' => 'Zahle District'],
            ['governorate_id' => 1, 'name_en' => 'Rashaya District'],
            ['governorate_id' => 2, 'name_en' => 'Akkar District'],
            ['governorate_id' => 3, 'name_en' => 'Metn District'],
            ['governorate_id' => 3, 'name_en' => 'Keserwan District'],
            ['governorate_id' => 4, 'name_en' => 'Tripoli District'],
            ['governorate_id' => 4, 'name_en' => 'Koura District'],
            ['governorate_id' => 5, 'name_en' => 'Saida District'],
            ['governorate_id' => 6, 'name_en' => 'Nabatieh District'],
            ['governorate_id' => 7, 'name_en' => 'Baalbek District'],
            ['governorate_id' => 8, 'name_en' => 'Beirut District'],
        ]);
    }
}
