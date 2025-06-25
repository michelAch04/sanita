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
            ['governorates_id' => 1, 'name_en' => 'Zahle District'],
            ['governorates_id' => 1, 'name_en' => 'Rashaya District'],
            ['governorates_id' => 2, 'name_en' => 'Akkar District'],
            ['governorates_id' => 3, 'name_en' => 'Metn District'],
            ['governorates_id' => 3, 'name_en' => 'Keserwan District'],
            ['governorates_id' => 4, 'name_en' => 'Tripoli District'],
            ['governorates_id' => 4, 'name_en' => 'Koura District'],
            ['governorates_id' => 5, 'name_en' => 'Saida District'],
            ['governorates_id' => 6, 'name_en' => 'Nabatieh District'],
            ['governorates_id' => 7, 'name_en' => 'Baalbek District'],
            ['governorates_id' => 8, 'name_en' => 'Beirut District'],
        ]);
    }
}
