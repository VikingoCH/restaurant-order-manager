<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu_sections')->insert([
            [
                'position'  => 1,
                'name'      => 'Tira-Gosto',
                'created_at' => now(),
            ],
            [
                'position'  => 2,
                'name'      => 'Pratos Principais',
                'created_at' => now(),
            ],
            [
                'position'  => 3,
                'name'      => 'Bebidas sem Àlcool',
                'created_at' => now(),
            ],
            [
                'position'  => 4,
                'name'      => 'Bebidas Alcoólica',
                'created_at' => now(),
            ],
            [
                'position'  => 5,
                'name'      => 'Sobremesa',
                'created_at' => now(),
            ],

        ]);
    }
}
