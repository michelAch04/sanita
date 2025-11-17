<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run()
    {
        DB::table('cities')->insert([
            // Beirut Governorate - Beirut District (assuming district_id=1)
            ['districts_id' => 1, 'name_en' => 'Beirut',       'name_ar' => 'بيروت',       'name_ku' => 'بیروت', 'created_at' => now(), 'updated_at' => now()],

            // Mount Lebanon Governorate - Aley District (district_id=2)
            ['districts_id' => 2, 'name_en' => 'Aley',         'name_ar' => 'عاليه',       'name_ku' => 'عالیە', 'created_at' => now(), 'updated_at' => now()],

            // Mount Lebanon Governorate - Baabda District (district_id=3)
            ['districts_id' => 3, 'name_en' => 'Baabda',       'name_ar' => 'بعبدا',       'name_ku' => 'باعەدا', 'created_at' => now(), 'updated_at' => now()],

            // Mount Lebanon Governorate - Chouf District (district_id=4)
            ['districts_id' => 4, 'name_en' => 'Deir al-Qamar', 'name_ar' => 'دير القمر',   'name_ku' => 'دێر ئەلقەمار', 'created_at' => now(), 'updated_at' => now()],
            ['districts_id' => 4, 'name_en' => 'Beiteddine',    'name_ar' => 'بيت الدين',   'name_ku' => 'بەیتەدین', 'created_at' => now(), 'updated_at' => now()],

            // Mount Lebanon Governorate - Matn District (district_id=5)
            ['districts_id' => 5, 'name_en' => 'Jdeideh',      'name_ar' => 'الجديدة',     'name_ku' => 'جدیدە', 'created_at' => now(), 'updated_at' => now()],

            // North Lebanon Governorate - Batroun District (district_id=6)
            ['districts_id' => 6, 'name_en' => 'Batroun',      'name_ar' => 'بترون',       'name_ku' => 'باترون', 'created_at' => now(), 'updated_at' => now()],

            // North Lebanon Governorate - Koura District (district_id=7)
            ['districts_id' => 7, 'name_en' => 'Amioun',       'name_ar' => 'أميون',       'name_ku' => 'ئامیون', 'created_at' => now(), 'updated_at' => now()],

            // North Lebanon Governorate - Miniyeh-Danniyeh District (district_id=8)
            ['districts_id' => 8, 'name_en' => 'Miniyeh',      'name_ar' => 'المنية',      'name_ku' => 'مینیە', 'created_at' => now(), 'updated_at' => now()],

            // North Lebanon Governorate - Zgharta District (district_id=9)
            ['districts_id' => 9, 'name_en' => 'Zgharta',      'name_ar' => 'زغرتا',       'name_ku' => 'زغرتا', 'created_at' => now(), 'updated_at' => now()],

            // Bekaa Governorate - Rashaya District (district_id=10)
            ['districts_id' => 10, 'name_en' => 'Rashaya',     'name_ar' => 'الراشيا',     'name_ku' => 'ڕاشیا', 'created_at' => now(), 'updated_at' => now()],

            // Bekaa Governorate - West Bekaa District (district_id=11)
            ['districts_id' => 11, 'name_en' => 'Jeb Jennine', 'name_ar' => 'جب جنين',     'name_ku' => 'جێب جەنین', 'created_at' => now(), 'updated_at' => now()],

            // Bekaa Governorate - Zahle District (district_id=12)
            ['districts_id' => 12, 'name_en' => 'Zahle',       'name_ar' => 'زحلة',        'name_ku' => 'زحڵە', 'created_at' => now(), 'updated_at' => now()],

            // South Lebanon Governorate - Jezzine District (district_id=13)
            ['districts_id' => 13, 'name_en' => 'Jezzine',     'name_ar' => 'جزين',        'name_ku' => 'جزین', 'created_at' => now(), 'updated_at' => now()],

            // South Lebanon Governorate - Sidon District (district_id=14)
            ['districts_id' => 14, 'name_en' => 'Sidon',       'name_ar' => 'صيدا',        'name_ku' => 'صیدا', 'created_at' => now(), 'updated_at' => now()],

            // South Lebanon Governorate - Tyre District (district_id=15)
            ['districts_id' => 15, 'name_en' => 'Tyre',        'name_ar' => 'صور',         'name_ku' => 'صور', 'created_at' => now(), 'updated_at' => now()],

            // Nabatieh Governorate - Bint Jbeil District (district_id=16)
            ['districts_id' => 16, 'name_en' => 'Bint Jbeil',  'name_ar' => 'بنت جبيل',    'name_ku' => 'بینت جبیل', 'created_at' => now(), 'updated_at' => now()],

            // Nabatieh Governorate - Hasbaya District (district_id=17)
            ['districts_id' => 17, 'name_en' => 'Hasbaya',     'name_ar' => 'حاصبيا',      'name_ku' => 'حاسبیا', 'created_at' => now(), 'updated_at' => now()],

            // Nabatieh Governorate - Marjeyoun District (district_id=18)
            ['districts_id' => 18, 'name_en' => 'Marjeyoun',   'name_ar' => 'المرجعيون',   'name_ku' => 'مارجعیون', 'created_at' => now(), 'updated_at' => now()],

            // Nabatieh Governorate - Nabatieh District (district_id=19)
            ['districts_id' => 19, 'name_en' => 'Nabatieh',    'name_ar' => 'النبطية',     'name_ku' => 'نباتێه', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
