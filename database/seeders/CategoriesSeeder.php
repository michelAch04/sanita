<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 1, 'position' => 1, 'name_en' => 'Household Care', 'name_ar' => 'العناية المنزلية', 'name_ku' => 'چاودێریی مال', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'position' => 2, 'name_en' => 'Personal Care', 'name_ar' => 'العناية الشخصية', 'name_ku' => 'چاودێریی کەسی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'position' => 3, 'name_en' => 'Feminine Well Being', 'name_ar' => 'العناية النسائية', 'name_ku' => 'خێزانی ڕۆژان', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'position' => 4, 'name_en' => 'Baby Care', 'name_ar' => 'العناية بالطفل', 'name_ku' => 'چاودێریی منداڵ', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'position' => 5, 'name_en' => 'Paramedical Care', 'name_ar' => 'العناية الطبية', 'name_ku' => 'چاودێری پزیشکی', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
