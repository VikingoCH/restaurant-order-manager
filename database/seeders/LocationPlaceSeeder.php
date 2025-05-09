<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            [
                'name' => 'none',
                'position' => 100,
                'physical' => false,
            ]

        ]);
        DB::table('places')->insert([
            [
                'number' => 0,
                'available' => true,
                'location_id' => 1,
            ]
        ]);
    }
}
