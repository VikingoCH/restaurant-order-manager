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
                'id'       => 1,
                'name'     => 'none',
                'position' => 100,
                'physical' => false,
                'created_at' => now(),
            ]

        ]);
        DB::table('places')->insert([
            [
                'number'      => 0,
                'available'   => true,
                'location_id' => 1,
                'created_at' => now(),
            ]
        ]);
    }
}
