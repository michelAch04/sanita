<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 1, 'position' => 1, 'name_en' => 'Paramedical Care', 'name_ar' => 'العناية الطبية المساعدة', 'name_ku' => 'چارەسەری پەراپزیشکی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'position' => 2, 'name_en' => 'Baby Care', 'name_ar' => 'رعاية الأطفال', 'name_ku' => 'چاودێری منداڵان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'position' => 3, 'name_en' => 'Feminine Well Being', 'name_ar' => 'راحة المرأة', 'name_ku' => 'سەلامەتی ژنان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'position' => 4, 'name_en' => 'Personal Care', 'name_ar' => 'العناية الشخصية', 'name_ku' => 'چاودێری کەسی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'position' => 5, 'name_en' => 'Household Care', 'name_ar' => 'العناية المنزلية', 'name_ku' => 'چاودێری ماڵەوە', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
