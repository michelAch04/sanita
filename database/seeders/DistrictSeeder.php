<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        DB::table('districts')->insert([
            // Beirut Governorate
            ['governorates_id' => 1, 'name_en' => 'Beirut',           'name_ar' => 'بيروت',       'name_ku' => 'بیروت', 'created_at' => now(), 'updated_at' => now()],

            // Mount Lebanon Governorate
            ['governorates_id' => 2, 'name_en' => 'Aley',             'name_ar' => 'عاليه',       'name_ku' => 'عالیە', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 2, 'name_en' => 'Baabda',           'name_ar' => 'بعبدا',       'name_ku' => 'باعەدا', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 2, 'name_en' => 'Chouf',            'name_ar' => 'الشوف',       'name_ku' => 'شوف', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 2, 'name_en' => 'Matn',             'name_ar' => 'المتن',       'name_ku' => 'مەتن', 'created_at' => now(), 'updated_at' => now()],

            // North Lebanon Governorate
            ['governorates_id' => 3, 'name_en' => 'Batroun',          'name_ar' => 'بترون',       'name_ku' => 'باترون', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 3, 'name_en' => 'Koura',            'name_ar' => 'الكورة',      'name_ku' => 'کورا', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 3, 'name_en' => 'Miniyeh-Danniyeh', 'name_ar' => 'المنية-الضنية', 'name_ku' => 'مینیه-داننێه', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 3, 'name_en' => 'Zgharta',          'name_ar' => 'زغرتا',       'name_ku' => 'زغرتا', 'created_at' => now(), 'updated_at' => now()],

            // Bekaa Governorate
            ['governorates_id' => 4, 'name_en' => 'Rashaya',          'name_ar' => 'الراشيا',     'name_ku' => 'ڕاشیا', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 4, 'name_en' => 'West Bekaa',       'name_ar' => 'البقاع الغربي', 'name_ku' => 'بەقاعی باشوور', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 4, 'name_en' => 'Zahle',            'name_ar' => 'زحلة',        'name_ku' => 'زحڵە', 'created_at' => now(), 'updated_at' => now()],

            // South Lebanon Governorate
            ['governorates_id' => 5, 'name_en' => 'Jezzine',          'name_ar' => 'جزين',        'name_ku' => 'جزین', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 5, 'name_en' => 'Sidon',            'name_ar' => 'صيدا',        'name_ku' => 'صیدا', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 5, 'name_en' => 'Tyre',             'name_ar' => 'صور',         'name_ku' => 'صور', 'created_at' => now(), 'updated_at' => now()],

            // Nabatieh Governorate
            ['governorates_id' => 6, 'name_en' => 'Bint Jbeil',       'name_ar' => 'بنت جبيل',    'name_ku' => 'بینت جبیل', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 6, 'name_en' => 'Hasbaya',          'name_ar' => 'حاصبيا',      'name_ku' => 'حاسبیا', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 6, 'name_en' => 'Marjeyoun',        'name_ar' => 'المرجعيون',   'name_ku' => 'مارجعیون', 'created_at' => now(), 'updated_at' => now()],
            ['governorates_id' => 6, 'name_en' => 'Nabatieh',         'name_ar' => 'النبطية',     'name_ku' => 'نباتێه', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
