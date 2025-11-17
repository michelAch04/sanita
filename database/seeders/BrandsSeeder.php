<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BrandsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('brands')->insert([
            ['id' => 1, 'name_en' => 'Baby Care', 'name_ar' => 'عناية الطفل', 'name_ku' => 'چاوی لە منداڵ', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name_en' => 'Baby Dreams', 'name_ar' => 'بيبي دريمز', 'name_ku' => 'خەونی منداڵان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name_en' => 'Charm', 'name_ar' => 'تشارم', 'name_ku' => 'سحر', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name_en' => 'Freshdays', 'name_ar' => 'فريش دايز', 'name_ku' => 'ڕۆژانی تازە', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name_en' => 'Relax', 'name_ar' => 'ريلاكس', 'name_ku' => 'ئارام', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name_en' => 'Sanita', 'name_ar' => 'سانيتا', 'name_ku' => 'سانیتا', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name_en' => 'Sanita Dreams', 'name_ar' => 'سانيتا دريمز', 'name_ku' => 'خەونی سانیتا', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name_en' => 'Sanita Gipsy', 'name_ar' => 'سانيتا جيبسي', 'name_ku' => 'سانیتا گیپسی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name_en' => 'Sanita Hand Sanitizer', 'name_ar' => 'معقم يد سانيتا', 'name_ku' => 'پاككردنەوەی دەست سانیتا', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name_en' => 'Sanita Handy', 'name_ar' => 'سانيتا هاندي', 'name_ku' => 'سانیتا هەندێ', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name_en' => 'Sanita My Home', 'name_ar' => 'سانيتا ماي هوم', 'name_ku' => 'سانیتا مەڵەکەم', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name_en' => 'Tendrex', 'name_ar' => 'تيندريكس', 'name_ku' => 'تێندریکس', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name_en' => 'Marvel', 'name_ar' => 'مارفيل', 'name_ku' => 'مارڤێل', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name_en' => 'Roltex', 'name_ar' => 'رولتيكس', 'name_ku' => 'رولتێکس', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name_en' => 'Sanita Club', 'name_ar' => 'سانيتا كلوب', 'name_ku' => 'یەکەی سانیتا', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name_en' => 'Rosana', 'name_ar' => 'روزانا', 'name_ku' => 'ڕۆسانا', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name_en' => 'Elegance', 'name_ar' => 'إيليجنس', 'name_ku' => 'سەرسوڕهێنەر', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name_en' => 'Softel', 'name_ar' => 'سوفْتِل', 'name_ku' => 'سۆفتێڵ', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
