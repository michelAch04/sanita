<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 1, 'position' => 1, 'name_en' => 'Cleaning Wipes', 'name_ar' => 'مناديل تنظيف', 'name_ku' => 'پاککەرەوەی پاککردن', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'position' => 2, 'name_en' => 'Garbage Bags & Bin Liners', 'name_ar' => 'أكياس قمامة وبطانات صناديق', 'name_ku' => 'جەلی پاک و لاینەری سطل', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'position' => 3, 'name_en' => 'Household Cleaning Products', 'name_ar' => 'منتجات تنظيف منزلية', 'name_ku' => 'بەرھەمە پاککردنەوەی خێزانی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'position' => 4, 'name_en' => 'Personal Care & Hygiene', 'name_ar' => 'العناية الشخصية والنظافة', 'name_ku' => 'چاودێری کەسی و پاکیزەیی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'position' => 5, 'name_en' => 'Disposable Tableware & Food Packaging', 'name_ar' => 'أواني طعام وأغلفة طعام للاستخدام مرة واحدة', 'name_ku' => 'کەرەستە و پاکێجی خواردنەوەیەک بۆ جارێک', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'position' => 6, 'name_en' => 'Sanitary Products', 'name_ar' => 'منتجات صحية', 'name_ku' => 'بەرھەمە تەندروستییەکان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
