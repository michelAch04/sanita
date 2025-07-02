<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run()
    {
        DB::table('cities')->insert([
            // Baghdad - Al Karkh District (1)
            ['districts_id' => 1, 'name_en' => 'Baghdad', 'name_ar' => 'بغداد', 'name_ku' => 'بەغداد', 'created_at' => now(), 'updated_at' => now()],
            ['districts_id' => 1, 'name_en' => 'Al-Jadiriya', 'name_ar' => 'الجعفرية', 'name_ku' => 'الجەدریة', 'created_at' => now(), 'updated_at' => now()],
            ['districts_id' => 1, 'name_en' => 'Al-Shaab', 'name_ar' => 'الشعب', 'name_ku' => 'الشعب', 'created_at' => now(), 'updated_at' => now()],
            // Baghdad - Al Rusafa District (2)
            ['districts_id' => 2, 'name_en' => 'Baghdad', 'name_ar' => 'بغداد', 'name_ku' => 'بەغداد', 'created_at' => now(), 'updated_at' => now()],
            ['districts_id' => 2, 'name_en' => 'Al-Mansour', 'name_ar' => 'المنصور', 'name_ku' => 'المنصور', 'created_at' => now(), 'updated_at' => now()],
            ['districts_id' => 2, 'name_en' => 'Sadr City', 'name_ar' => 'مدينة الصدر', 'name_ku' => 'شارە سەدر', 'created_at' => now(), 'updated_at' => now()],
            // Baghdad - Abu Ghraib District (3)
            ['districts_id' => 3, 'name_en' => 'Abu Ghraib', 'name_ar' => 'أبو غريب', 'name_ku' => 'ئابوغریب', 'created_at' => now(), 'updated_at' => now()],
            ['districts_id' => 3, 'name_en' => 'Al-Taji', 'name_ar' => 'التاجي', 'name_ku' => 'تاجی', 'created_at' => now(), 'updated_at' => now()],
            // Basra - Basra District (4)
            ['districts_id' => 4, 'name_en' => 'Basra', 'name_ar' => 'البصرة', 'name_ku' => 'بەسڕە', 'created_at' => now(), 'updated_at' => now()],
            ['districts_id' => 4, 'name_en' => 'Al-Zubair', 'name_ar' => 'الزبير', 'name_ku' => 'زوبیر', 'created_at' => now(), 'updated_at' => now()],
            ['districts_id' => 4, 'name_en' => 'Shatt al-Arab', 'name_ar' => 'شط العرب', 'name_ku' => 'شط العرب', 'created_at' => now(), 'updated_at' => now()],
            // Basra - Al-Qurna District (5)
            ['districts_id' => 5, 'name_en' => 'Al-Qurna', 'name_ar' => 'القرنة', 'name_ku' => 'القورنه', 'created_at' => now(), 'updated_at' => now()],
            ['districts_id' => 5, 'name_en' => 'Al-Busayyah', 'name_ar' => 'البصية', 'name_ku' => 'البصية', 'created_at' => now(), 'updated_at' => now()],
            // Basra - Al-Medina District (6)
            ['districts_id' => 6, 'name_en' => 'Al-Medina', 'name_ar' => 'المدينة', 'name_ku' => 'المدینة', 'created_at' => now(), 'updated_at' => now()],
            ['districts_id' => 6, 'name_en' => 'Al-Hartha', 'name_ar' => 'الهارثة', 'name_ku' => 'هارثة', 'created_at' => now(), 'updated_at' => now()],
            // ...continue for all districts and cities as above...
        ]);
    }
}
