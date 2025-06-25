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
            ['districts_id' => 1, 'name_en' => 'Zahle City'],
            ['districts_id' => 2, 'name_en' => 'Rashaya City'],
            ['districts_id' => 3, 'name_en' => 'Akkar City'],
            ['districts_id' => 4, 'name_en' => 'Jdeideh'],
            ['districts_id' => 5, 'name_en' => 'Jounieh'],
            ['districts_id' => 6, 'name_en' => 'Tripoli'],
            ['districts_id' => 7, 'name_en' => 'Amioun'],
            ['districts_id' => 8, 'name_en' => 'Saida City'],
            ['districts_id' => 9, 'name_en' => 'Nabatieh City'],
            ['districts_id' => 10, 'name_en' => 'Baalbek City'],
            ['districts_id' => 11, 'name_en' => 'Beirut City'],
        ]);
    }
}
