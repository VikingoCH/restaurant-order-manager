<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu_sides')->insert([
            [
                'position'  => 1,
                'name'      => 'Arroz',
                'created_at' => now(),
            ],
            [
                'position'  => 2,
                'name'      => 'Feijão',
                'created_at' => now(),
            ],
            [
                'position'  => 3,
                'name'      => 'Batata frita',
                'created_at' => now(),
            ],
            [
                'position'  => 4,
                'name'      => 'Mandioca frita',
                'created_at' => now(),
            ],

        ]);
    }
}
