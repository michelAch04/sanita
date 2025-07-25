<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subcategories')->insert([
            ['categories_id' => 1, 'position' => 1, 'name_en' => 'Cleaning Solutions', 'name_ar' => 'محاليل التنظيف', 'name_ku' => 'چاره‌سەرە پاککردنەوەکان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['categories_id' => 1, 'position' => 2, 'name_en' => 'Food Wrapping Containers', 'name_ar' => 'علب تغليف الطعام', 'name_ku' => 'قەبارەی خواردن', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],

            ['categories_id' => 2, 'position' => 3, 'name_en' => 'Baby Diapers', 'name_ar' => 'حفاضات الأطفال', 'name_ku' => 'پۆشەی منداڵان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['categories_id' => 2, 'position' => 4, 'name_en' => 'Baby Hygiene', 'name_ar' => 'نظافة الطفل', 'name_ku' => 'پاکیزەیی منداڵ', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],

            ['categories_id' => 3, 'position' => 5, 'name_en' => 'Protection Hygiene', 'name_ar' => 'حماية النظافة', 'name_ku' => 'پاراستنی پاکیزەیی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['categories_id' => 3, 'position' => 6, 'name_en' => 'Freshness & Well Being', 'name_ar' => 'الانتعاش والراحة', 'name_ku' => 'تازەیی و ئاسودەیی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['categories_id' => 3, 'position' => 7, 'name_en' => 'Incontinence', 'name_ar' => 'سلس البول', 'name_ku' => 'کێشەی پاراستن', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['categories_id' => 3, 'position' => 8, 'name_en' => 'Beauty', 'name_ar' => 'الجمال', 'name_ku' => 'ڕەق', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],

            ['categories_id' => 4, 'position' => 9, 'name_en' => 'Family Hygiene', 'name_ar' => 'نظافة العائلة', 'name_ku' => 'پاکیزەیی خێزان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],

            ['categories_id' => 5, 'position' => 10, 'name_en' => 'Adult Incontinence', 'name_ar' => 'سلس البول للكبار', 'name_ku' => 'ناتوانی پاراستن لە گەورەکان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['categories_id' => 5, 'position' => 11, 'name_en' => 'Hygienic Protection', 'name_ar' => 'الحماية الصحية', 'name_ku' => 'پاراستنی تەندروستی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
