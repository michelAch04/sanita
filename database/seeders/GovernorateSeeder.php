<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernorateSeeder extends Seeder
{
    public function run()
    {
        DB::table('governorates')->insert([
            ['name_en' => 'Baghdad',      'name_ar' => 'بغداد',        'name_ku' => 'بەغداد'],
            ['name_en' => 'Basra',        'name_ar' => 'البصرة',       'name_ku' => 'بەسڕە'],
            ['name_en' => 'Nineveh',      'name_ar' => 'نينوى',        'name_ku' => 'نینەوا'],
            ['name_en' => 'Erbil',        'name_ar' => 'أربيل',        'name_ku' => 'هەولێر'],
            ['name_en' => 'Sulaymaniyah', 'name_ar' => 'السليمانية',   'name_ku' => 'سلێمانی'],
            ['name_en' => 'Dhi Qar',      'name_ar' => 'ذي قار',       'name_ku' => 'ذی قار'],
            ['name_en' => 'Kirkuk',       'name_ar' => 'كركوك',        'name_ku' => 'که‌رکوک'],
            ['name_en' => 'Najaf',        'name_ar' => 'النجف',        'name_ku' => 'نجف'],
            ['name_en' => 'Babil',        'name_ar' => 'بابل',         'name_ku' => 'بابل'],
            ['name_en' => 'Diyala',       'name_ar' => 'ديالى',        'name_ku' => 'دیالە'],
            ['name_en' => 'Al Anbar',     'name_ar' => 'الأنبار',      'name_ku' => 'ئەنبار'],
            ['name_en' => 'Wasit',        'name_ar' => 'واسط',         'name_ku' => 'واسط'],
            ['name_en' => 'Maysan',       'name_ar' => 'ميسان',        'name_ku' => 'مەيسان'],
            ['name_en' => 'Muthanna',     'name_ar' => 'المثنى',       'name_ku' => 'مثنى'],
            ['name_en' => 'Qadisiyyah',   'name_ar' => 'القادسية',     'name_ku' => 'قادسیە'],
            ['name_en' => 'Karbala',      'name_ar' => 'كربلاء',       'name_ku' => 'کربلاء'],
            ['name_en' => 'Dohuk',        'name_ar' => 'دهوك',         'name_ku' => 'دهۆک'],
            ['name_en' => 'Salahdin',      'name_ar' => 'صلاح الدين',   'name_ku' => 'سەلاحەدین'],
            ['name_en' => 'Halabja',      'name_ar' => 'حلبجة',        'name_ku' => 'ھەڵەبجە'],
        ]);
    }
}
