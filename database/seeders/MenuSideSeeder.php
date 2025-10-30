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
            ['name' => 'Arroz', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Feijão', 'position'  => 2, 'created_at' => now()],
            ['name' => 'Batata frita', 'position'  => 3, 'created_at' => now()],
            ['name' => 'Mandioca frita', 'position'  => 4, 'created_at' => now()],
            ['name' => 'Banana Frita', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Couve', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Salada Vinagret', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Caju', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Cajá', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Maracujá', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Laranja', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Açaí', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Goiaba', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Cupuaçu', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Limão', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Graviola', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Acerola', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Manga', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Abacaxi', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Limette', 'position'  => 1, 'created_at' => now()],
            ['name' => 'Orange', 'position'  => 1, 'created_at' => now()],

        ]);
    }
}
