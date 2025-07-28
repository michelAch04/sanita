<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernorateSeeder extends Seeder
{
    public function run()
    {
        DB::table('governorates')->insert([
            ['name_en' => 'Beirut',          'name_ar' => 'بيروت',       'name_ku' => 'بیروت'],
            ['name_en' => 'Mount Lebanon',   'name_ar' => 'لبنان الجبل',  'name_ku' => 'چیاکانی لبنان'],
            ['name_en' => 'North Lebanon',   'name_ar' => 'شمال لبنان',   'name_ku' => 'باخەکانی لبنان'],
            ['name_en' => 'Bekaa',           'name_ar' => 'البقاع',       'name_ku' => 'بەقاع'],
            ['name_en' => 'South Lebanon',   'name_ar' => 'جنوب لبنان',   'name_ku' => 'باشووری لبنان'],
            ['name_en' => 'Nabatieh',        'name_ar' => 'النبطية',      'name_ku' => 'نباتێه'],
        ]);
    }
}
