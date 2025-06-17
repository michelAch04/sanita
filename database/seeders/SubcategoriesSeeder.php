<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subcategories')->insert([
            ['id'=>1,'categories_id'=>1,'position'=>1,'name_en'=>'Food Wrapping & Containers','name_ar'=>'تغليف الطعام','name_ku'=>'پەرتووک و پارچەکردنی خواردن','extension'=>null,'hidden'=>0,'cancelled'=>0,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>2,'categories_id'=>1,'position'=>2,'name_en'=>'Cleaning Solutions','name_ar'=>'منتجات التنظيف','name_ku'=>'چاودێری پاککاری','extension'=>null,'hidden'=>0,'cancelled'=>0,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>3,'categories_id'=>5,'position'=>3,'name_en'=>'Adult Incontinence','name_ar'=>'سلس البول للكبار','name_ku'=>'هێڵمەنی پێشەوەی گەورەکان','extension'=>null,'hidden'=>0,'cancelled'=>0,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>4,'categories_id'=>4,'position'=>4,'name_en'=>'Baby Hygiene','name_ar'=>'النظافة للأطفال','name_ku'=>'پاکیزەی منداڵان','extension'=>null,'hidden'=>0,'cancelled'=>0,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>5,'categories_id'=>2,'position'=>5,'name_en'=>'Family Hygiene','name_ar'=>'نظافة الأسرة','name_ku'=>'پاکیزەی خێزان','extension'=>null,'hidden'=>0,'cancelled'=>0,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>6,'categories_id'=>3,'position'=>6,'name_en'=>'Beauty','name_ar'=>'الجمال','name_ku'=>'ژیانی خۆش','extension'=>null,'hidden'=>0,'cancelled'=>0,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>7,'categories_id'=>3,'position'=>7,'name_en'=>'Protection & Hygiene','name_ar'=>'الحماية والنظافة','name_ku'=>'پاراستن و پاکیزەیی','extension'=>null,'hidden'=>0,'cancelled'=>0,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>8,'categories_id'=>3,'position'=>8,'name_en'=>'Freshness & Well Being','name_ar'=>'الانتعاش والعافية','name_ku'=>'تازەکاری و باشی','extension'=>null,'hidden'=>0,'cancelled'=>0,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>9,'categories_id'=>5,'position'=>9,'name_en'=>'Hygienic Protection','name_ar'=>'الحماية الصحية','name_ku'=>'پاراستنی تەندروستی','extension'=>null,'hidden'=>0,'cancelled'=>0,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>10,'categories_id'=>4,'position'=>10,'name_en'=>'Baby Diapers','name_ar'=>'حفاضات الأطفال','name_ku'=>'پێشکەوتەکانی منداڵان','extension'=>null,'hidden'=>0,'cancelled'=>0,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>11,'categories_id'=>3,'position'=>11,'name_en'=>'Incontinence','name_ar'=>'سلس البول','name_ku'=>'هێڵمەنی تەندروستی','extension'=>null,'hidden'=>0,'cancelled'=>0,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>12,'categories_id'=>3,'position'=>12,'name_en'=>'Maternity','name_ar'=>'الأمومة','name_ku'=>'دایکی','extension'=>null,'hidden'=>0,'cancelled'=>0,'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
