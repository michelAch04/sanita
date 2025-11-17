<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('taxes')->insert([
            [
                'name'        => 'Standard VAT',
                'rate'        => 15.00,
                'active'      => 1,
                'cancelled'   => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Reduced VAT',
                'rate'        => 5.00,
                'active'      => 1,
                'cancelled'   => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Zero Rate',
                'rate'        => 0.00,
                'active'      => 1,
                'cancelled'   => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
