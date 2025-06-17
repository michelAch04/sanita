<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('brands')->insert([
            ['id' => 1, 'name_en' => 'Sanita My Home', 'name_ar' => 'سانيتا ماي هوم', 'name_ku' => 'سانیتا مەڵەکەم', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name_en' => 'Sanita My Shield', 'name_ar' => 'سانيتا ماي شيلد', 'name_ku' => 'سانیتا پاراستنم', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name_en' => 'Happies', 'name_ar' => 'هابييز', 'name_ku' => 'خۆشحاڵ', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name_en' => 'Dreams', 'name_ar' => 'دريمز', 'name_ku' => 'خەون', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name_en' => 'Private', 'name_ar' => 'برايفت', 'name_ku' => 'تایبەت', 'extension' => null, 'hidden' => 0, 'cancelled' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
