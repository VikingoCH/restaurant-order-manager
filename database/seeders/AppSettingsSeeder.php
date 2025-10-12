<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('app_settings')->insert(
            [
                [
                    'order_prefix' => 'ORD',
                    'quick_order_name' => 'Verschiedene Gerichte',
                    'tax' => 7.7,
                    'rows_per_page' => 10,
                    'printer_store_website' => 'picahna-brasil.ch',
                    'printer_store_email' => 'info@picahna-brasil.ch',
                    'printer_store_phone' => '+41 44 821 64 31',
                    'printer_store_address' => 'Wangenstrasse 37, 8600 Dübendorf, CH',
                    'printer_store_name_1' => 'Picanha Brasil',
                    'printer_store_name_2' => 'Dübendorf',
                ],

            ]
        );
    }
}
