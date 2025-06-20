<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subcategories')->insert([
            // Household Care
            ['id' => 1, 'categories_id' => 1, 'position' => 1, 'name_en' => 'Cleaning Solutions', 'name_ar' => 'منتجات التنظيف', 'name_ku' => 'چاودێری پاککاری', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'categories_id' => 1, 'position' => 2, 'name_en' => 'Laundry Detergents', 'name_ar' => 'منظفات الغسيل', 'name_ku' => 'پاککردنەوەی پەراوەکان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'categories_id' => 1, 'position' => 3, 'name_en' => 'Air Fresheners', 'name_ar' => 'معطرات الجو', 'name_ku' => 'فەرەشکردنەوەی هەوا', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'categories_id' => 1, 'position' => 4, 'name_en' => 'Trash Bags', 'name_ar' => 'أكياس القمامة', 'name_ku' => 'پاکسازی زەبەڵەکان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'categories_id' => 1, 'position' => 5, 'name_en' => 'Dishwashing Supplies', 'name_ar' => 'أدوات غسيل الصحون', 'name_ku' => 'کەلەی فریش کردنەوە', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],

            // Personal Care
            ['id' => 6, 'categories_id' => 2, 'position' => 6, 'name_en' => 'Hair Care', 'name_ar' => 'العناية بالشعر', 'name_ku' => 'چاودێریی پەستەکان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'categories_id' => 2, 'position' => 7, 'name_en' => 'Skin Care', 'name_ar' => 'العناية بالبشرة', 'name_ku' => 'چاودێریی پەستەکان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'categories_id' => 2, 'position' => 8, 'name_en' => 'Oral Care', 'name_ar' => 'العناية بالفم', 'name_ku' => 'چاودێریی پەستەکان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'categories_id' => 2, 'position' => 9, 'name_en' => 'Shaving & Hair Removal', 'name_ar' => 'الحلاقة وإزالة الشعر', 'name_ku' => 'شیوکردن و بردن پەستەکان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'categories_id' => 2, 'position' => 10, 'name_en' => 'Fragrances', 'name_ar' => 'العطور', 'name_ku' => 'بەوەری', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],

            // Feminine Well Being
            ['id' => 11, 'categories_id' => 3, 'position' => 11, 'name_en' => 'Feminine Hygiene', 'name_ar' => 'النظافة النسائية', 'name_ku' => 'پاکیزەی زەوی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'categories_id' => 3, 'position' => 12, 'name_en' => 'Menstrual Care', 'name_ar' => 'العناية بالدورة الشهرية', 'name_ku' => 'خوشەویستی مانگانی ژن', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'categories_id' => 3, 'position' => 13, 'name_en' => 'Breast Care', 'name_ar' => 'العناية بالثدي', 'name_ku' => 'چاوەڕوانی بەرز', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'categories_id' => 3, 'position' => 14, 'name_en' => 'Feminine Deodorants', 'name_ar' => 'مزيلات العرق النسائية', 'name_ku' => 'دورمارییەکانی ژن', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'categories_id' => 3, 'position' => 15, 'name_en' => 'Feminine Health Supplements', 'name_ar' => 'مكملات الصحة النسائية', 'name_ku' => 'پەیوەندیدانی ژن', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],

            // Baby Care
            ['id' => 16, 'categories_id' => 4, 'position' => 16, 'name_en' => 'Baby Hygiene', 'name_ar' => 'النظافة للأطفال', 'name_ku' => 'پاکیزەی منداڵان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'categories_id' => 4, 'position' => 17, 'name_en' => 'Baby Diapers', 'name_ar' => 'حفاضات الأطفال', 'name_ku' => 'پێشکەوتەکانی منداڵان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'categories_id' => 4, 'position' => 18, 'name_en' => 'Baby Food', 'name_ar' => 'أطعمة الأطفال', 'name_ku' => 'خواردنەوەی منداڵان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'categories_id' => 4, 'position' => 19, 'name_en' => 'Baby Health', 'name_ar' => 'صحة الأطفال', 'name_ku' => 'تەندروستی منداڵان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'categories_id' => 4, 'position' => 20, 'name_en' => 'Baby Care Accessories', 'name_ar' => 'إكسسوارات العناية بالأطفال', 'name_ku' => 'تازەیەکانی منداڵان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],

            // Paramedical Care
            ['id' => 21, 'categories_id' => 5, 'position' => 21, 'name_en' => 'Incontinence', 'name_ar' => 'سلس البول', 'name_ku' => 'هێڵمەنی تەندروستی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'categories_id' => 5, 'position' => 22, 'name_en' => 'Pain Relief', 'name_ar' => 'مسكنات الألم', 'name_ku' => 'داروەکان بۆ کەمدەکردن', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'categories_id' => 5, 'position' => 23, 'name_en' => 'Wound Care', 'name_ar' => 'العناية بالجروح', 'name_ku' => 'چاودێری پەیوەندیدانی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'categories_id' => 5, 'position' => 24, 'name_en' => 'Medical Equipment', 'name_ar' => 'المعدات الطبية', 'name_ku' => 'ئامرازە پزیشکی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'categories_id' => 5, 'position' => 25, 'name_en' => 'First Aid', 'name_ar' => 'الإسعافات الأولية', 'name_ku' => 'پەیوەندی یەکەمی پزیشکی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
