<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        DB::table('districts')->insert([
            // Baghdad
            ['id' => 1, 'governorates_id' => 1, 'name_en' => 'Al Karkh', 'name_ar' => 'الكرخ', 'name_ku' => 'الکرخ', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'governorates_id' => 1, 'name_en' => 'Al Rusafa', 'name_ar' => 'الرصافة', 'name_ku' => 'الرصافة', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'governorates_id' => 1, 'name_en' => 'Abu Ghraib', 'name_ar' => 'أبو غريب', 'name_ku' => 'ئابوغریب', 'created_at' => now(), 'updated_at' => now()],
            // Basra
            ['id' => 4, 'governorates_id' => 2, 'name_en' => 'Basra', 'name_ar' => 'البصرة', 'name_ku' => 'بەسڕە', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'governorates_id' => 2, 'name_en' => 'Al-Qurna', 'name_ar' => 'القرنة', 'name_ku' => 'القورنه', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'governorates_id' => 2, 'name_en' => 'Al-Medina', 'name_ar' => 'المدينة', 'name_ku' => 'المدینة', 'created_at' => now(), 'updated_at' => now()],
            // Nineveh
            ['id' => 7, 'governorates_id' => 3, 'name_en' => 'Mosul', 'name_ar' => 'الموصل', 'name_ku' => 'مووسڵ', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'governorates_id' => 3, 'name_en' => 'Tel Kaif', 'name_ar' => 'تلكيف', 'name_ku' => 'تەلکیف', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'governorates_id' => 3, 'name_en' => 'Sinjar', 'name_ar' => 'سنجار', 'name_ku' => 'شنگال', 'created_at' => now(), 'updated_at' => now()],
            // Kirkuk
            ['id' => 10, 'governorates_id' => 4, 'name_en' => 'Kirkuk', 'name_ar' => 'كركوك', 'name_ku' => 'که‌رکوک', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'governorates_id' => 4, 'name_en' => 'Hawija', 'name_ar' => 'الحويجة', 'name_ku' => 'حەویجە', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'governorates_id' => 4, 'name_en' => 'Tuz Khurmatu', 'name_ar' => 'طوز خورماتو', 'name_ku' => 'توزخورماتو', 'created_at' => now(), 'updated_at' => now()],
            // Dhi Qar
            ['id' => 13, 'governorates_id' => 5, 'name_en' => 'Nasiriyah', 'name_ar' => 'الناصرية', 'name_ku' => 'نەصریە', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'governorates_id' => 5, 'name_en' => 'Al-Qadisiyyah', 'name_ar' => 'القادسية', 'name_ku' => 'قادسیە', 'created_at' => now(), 'updated_at' => now()],
            // Sulaymaniyah
            ['id' => 15, 'governorates_id' => 6, 'name_en' => 'Sulaymaniyah', 'name_ar' => 'السليمانية', 'name_ku' => 'سلێمانی', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'governorates_id' => 6, 'name_en' => 'Halabja', 'name_ar' => 'حلبجة', 'name_ku' => 'ھەڵەبجە', 'created_at' => now(), 'updated_at' => now()],
            // Erbil
            ['id' => 17, 'governorates_id' => 7, 'name_en' => 'Erbil', 'name_ar' => 'أربيل', 'name_ku' => 'هەولێر', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'governorates_id' => 7, 'name_en' => 'Soran', 'name_ar' => 'سوران', 'name_ku' => 'سۆران', 'created_at' => now(), 'updated_at' => now()],
            // Anbar
            ['id' => 19, 'governorates_id' => 8, 'name_en' => 'Ramadi', 'name_ar' => 'الرمادي', 'name_ku' => 'ڕەمادی', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'governorates_id' => 8, 'name_en' => 'Fallujah', 'name_ar' => 'الفلوجة', 'name_ku' => 'فەڵوجە', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'governorates_id' => 8, 'name_en' => 'Al-Qaim', 'name_ar' => 'القائم', 'name_ku' => 'قائم', 'created_at' => now(), 'updated_at' => now()],
            // Najaf
            ['id' => 22, 'governorates_id' => 9, 'name_en' => 'Najaf', 'name_ar' => 'النجف', 'name_ku' => 'نجف', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'governorates_id' => 9, 'name_en' => 'Al-Qadisiyyah', 'name_ar' => 'القادسية', 'name_ku' => 'قادسیە', 'created_at' => now(), 'updated_at' => now()],
            // Karbala
            ['id' => 24, 'governorates_id' => 10, 'name_en' => 'Karbala', 'name_ar' => 'كربلاء', 'name_ku' => 'کربلاء', 'created_at' => now(), 'updated_at' => now()],
            // Muthanna
            ['id' => 25, 'governorates_id' => 11, 'name_en' => 'Samawah', 'name_ar' => 'السماوة', 'name_ku' => 'سەمەوە', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'governorates_id' => 11, 'name_en' => 'Al-Rumaitha', 'name_ar' => 'الرميثة', 'name_ku' => 'ڕومەیثە', 'created_at' => now(), 'updated_at' => now()],
            // Wasit
            ['id' => 27, 'governorates_id' => 12, 'name_en' => 'Kut', 'name_ar' => 'الكوت', 'name_ku' => 'کوت', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'governorates_id' => 12, 'name_en' => 'Al-Suwaira', 'name_ar' => 'الصويرة', 'name_ku' => 'سویره', 'created_at' => now(), 'updated_at' => now()],
            // Babil
            ['id' => 29, 'governorates_id' => 13, 'name_en' => 'Hillah', 'name_ar' => 'الحلة', 'name_ku' => 'حڵە', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'governorates_id' => 13, 'name_en' => 'Al-Musayyib', 'name_ar' => 'المسيب', 'name_ku' => 'مسیب', 'created_at' => now(), 'updated_at' => now()],
            // Salah ad-Din
            ['id' => 31, 'governorates_id' => 14, 'name_en' => 'Tikrit', 'name_ar' => 'تكريت', 'name_ku' => 'تکریت', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'governorates_id' => 14, 'name_en' => 'Balad', 'name_ar' => 'بلد', 'name_ku' => 'بەلەد', 'created_at' => now(), 'updated_at' => now()],
            // Diyala
            ['id' => 33, 'governorates_id' => 15, 'name_en' => 'Baqubah', 'name_ar' => 'بعقوبة', 'name_ku' => 'بەعقوبە', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'governorates_id' => 15, 'name_en' => 'Khanaqin', 'name_ar' => 'خانقين', 'name_ku' => 'خانقین', 'created_at' => now(), 'updated_at' => now()],
            // Al-Qadisiyyah
            ['id' => 35, 'governorates_id' => 16, 'name_en' => 'Diwaniya', 'name_ar' => 'الديوانية', 'name_ku' => 'دیوانیە', 'created_at' => now(), 'updated_at' => now()],
            // Maysan
            ['id' => 36, 'governorates_id' => 18, 'name_en' => 'Amara', 'name_ar' => 'العمارة', 'name_ku' => 'عمارە', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
