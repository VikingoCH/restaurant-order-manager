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
                ],

            ]
        );
    }
}
