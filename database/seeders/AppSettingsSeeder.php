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
                    'id'               => 1,
                    'order_prefix'     => 'ORD',
                    'quick_order_name' => 'Verschiedene Gerichte',
                    'tax'              => 8.1,
                    'rows_per_page'    => 20,
                    'default_printer'  => 1,
                    'created_at' => now(),
                ],

            ]
        );
    }
}
