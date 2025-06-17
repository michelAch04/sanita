<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernorateSeeder extends Seeder
{
    public function run()
    {
        DB::table('governorates')->insert([
            ['name_en' => 'Beqaa Governorate'],
            ['name_en' => 'Akkar Governorate'],
            ['name_en' => 'Mount Lebanon Governorate'],
            ['name_en' => 'North Governorate'],
            ['name_en' => 'South Governorate'],
            ['name_en' => 'Nabatieh Governorate'],
            ['name_en' => 'Baalbek-Hermel Governorate'],
            ['name_en' => 'Beirut Governorate'],
        ]);
    }
}
