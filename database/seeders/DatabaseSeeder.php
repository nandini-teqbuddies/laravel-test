<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Product A',
                'price' => '10',
            ],
            [
                'name' => 'Product B',
                'price' => '8',
            ],
            [
                'name' => 'Product C',
                'price' => '12',
            ],
        ]);

        DB::table('vouchers')->insert([
            [
                'name' => 'Voucher V',
                'description' => '10% off discount voucher for the second unit applying only to Product A',
            ],
            [
                'name' => 'Voucher R',
                'description' => '5€ off discount on product type B',
            ],
            [
                'name' => 'Voucher S',
                'description' => '5% discount on a cart value over 40€',
            ],
        
        ]);
    }
}
