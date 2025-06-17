<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run()
    {
        // Assuming district IDs start from 1 accordingly
        DB::table('cities')->insert([
            ['district_id' => 1, 'name_en' => 'Zahle City'],
            ['district_id' => 2, 'name_en' => 'Rashaya City'],
            ['district_id' => 3, 'name_en' => 'Akkar City'],
            ['district_id' => 4, 'name_en' => 'Jdeideh'],
            ['district_id' => 5, 'name_en' => 'Jounieh'],
            ['district_id' => 6, 'name_en' => 'Tripoli'],
            ['district_id' => 7, 'name_en' => 'Amioun'],
            ['district_id' => 8, 'name_en' => 'Saida City'],
            ['district_id' => 9, 'name_en' => 'Nabatieh City'],
            ['district_id' => 10, 'name_en' => 'Baalbek City'],
            ['district_id' => 11, 'name_en' => 'Beirut City'],
        ]);
    }
}
