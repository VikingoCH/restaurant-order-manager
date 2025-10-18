<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu_items')->insert(
            [
                ['position' => 1, 'name' => 'Picanha: Porção grande ', 'price' => 35.00, 'image_path' => NULL, 'menu_section_id' => 2, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 2, 'name' => 'Picanha: Porção pequena ', 'price' => 30.00, 'image_path' => NULL, 'menu_section_id' => 2, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 6, 'name' => 'Figato', 'price' => 25.00, 'image_path' => NULL, 'menu_section_id' => 2, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 1, 'name' => 'Picanha a Palito ', 'price' => 28.00, 'image_path' => NULL, 'menu_section_id' => 1, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 2, 'name' => 'Coxinha ', 'price' => 4.00, 'image_path' => NULL, 'menu_section_id' => 1, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 1, 'name' => 'Coca Cola', 'price' => 5.00, 'image_path' => NULL, 'menu_section_id' => 3, 'printer_id' => 1, 'created_at' => now()],
                ['position' => 2, 'name' => 'Guarana', 'price' => 7.00, 'image_path' => NULL, 'menu_section_id' => 3, 'printer_id' => 1, 'created_at' => now()],
                ['position' => 1, 'name' => 'Heineken', 'price' => 8.00, 'image_path' => NULL, 'menu_section_id' => 4, 'printer_id' => 1, 'created_at' => now()],
                ['position' => 2, 'name' => 'Pinha colada', 'price' => 17.00, 'image_path' => NULL, 'menu_section_id' => 4, 'printer_id' => 1, 'created_at' => now()],
                ['position' => 3, 'name' => 'Carne Seca Grande', 'price' => 35.00, 'image_path' => NULL, 'menu_section_id' => 2, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 4, 'name' => 'Carne Seca Piccola', 'price' => 30.00, 'image_path' => NULL, 'menu_section_id' => 2, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 1, 'name' => 'Musse de Maracuia', 'price' => 8.00, 'image_path' => NULL, 'menu_section_id' => 5, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 2, 'name' => 'PUDIM', 'price' => 8.00, 'image_path' => NULL, 'menu_section_id' => 5, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 3, 'name' => 'BOLO', 'price' => 8.00, 'image_path' => NULL, 'menu_section_id' => 5, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 7, 'name' => 'PITO DE FRANGO', 'price' => 25.00, 'image_path' => NULL, 'menu_section_id' => 2, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 5, 'name' => 'Bistecca', 'price' => 38.00, 'image_path' => NULL, 'menu_section_id' => 2, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 8, 'name' => 'Fejuada', 'price' => 30.00, 'image_path' => NULL, 'menu_section_id' => 2, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 8, 'name' => 'Camarao', 'price' => 36.00, 'image_path' => NULL, 'menu_section_id' => 2, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 9, 'name' => 'Bacalhau', 'price' => 38.00, 'image_path' => NULL, 'menu_section_id' => 2, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 1, 'name' => 'Picanha Palito', 'price' => 28.00, 'image_path' => NULL, 'menu_section_id' => 1, 'printer_id' => 2, 'created_at' => now()],
                ['position' => 2, 'name' => 'Carne Seca a Palito', 'price' => 28.00, 'image_path' => NULL, 'menu_section_id' => 1, 'printer_id' => 2, 'created_at' => now()],
            ]
        );

        DB::table('menu_selectable_sides')->insert([
            ['menu_side_id' => 3, 'menu_item_id' => 1, 'created_at' => now()],
            ['menu_side_id' => 4, 'menu_item_id' => 1, 'created_at' => now()],
            ['menu_side_id' => 3, 'menu_item_id' => 2, 'created_at' => now()],
            ['menu_side_id' => 4, 'menu_item_id' => 2, 'created_at' => now()],
            ['menu_side_id' => 4, 'menu_item_id' => 3, 'created_at' => now()],
            ['menu_side_id' => 3, 'menu_item_id' => 3, 'created_at' => now()],
            ['menu_side_id' => 3, 'menu_item_id' => 10, 'created_at' => now()],
            ['menu_side_id' => 4, 'menu_item_id' => 10, 'created_at' => now()],
            ['menu_side_id' => 3, 'menu_item_id' => 11, 'created_at' => now()],
            ['menu_side_id' => 4, 'menu_item_id' => 11, 'created_at' => now()],
            ['menu_side_id' => 3, 'menu_item_id' => 16, 'created_at' => now()],
            ['menu_side_id' => 4, 'menu_item_id' => 16, 'created_at' => now()],
        ]);

        DB::table('menu_fixed_sides')->insert(
            [
                ['menu_side_id' => 1, 'menu_item_id' => 1, 'created_at' => now()],
                ['menu_side_id' => 2, 'menu_item_id' => 1, 'created_at' => now()],
                ['menu_side_id' => 1, 'menu_item_id' => 2, 'created_at' => now()],
                ['menu_side_id' => 2, 'menu_item_id' => 2, 'created_at' => now()],
                ['menu_side_id' => 1, 'menu_item_id' => 10, 'created_at' => now()],
                ['menu_side_id' => 2, 'menu_item_id' => 10, 'created_at' => now()],
                ['menu_side_id' => 1, 'menu_item_id' => 11, 'created_at' => now()],
                ['menu_side_id' => 2, 'menu_item_id' => 11, 'created_at' => now()],
                ['menu_side_id' => 1, 'menu_item_id' => 15, 'created_at' => now()],
                ['menu_side_id' => 2, 'menu_item_id' => 15, 'created_at' => now()],
                ['menu_side_id' => 1, 'menu_item_id' => 16, 'created_at' => now()],
                ['menu_side_id' => 2, 'menu_item_id' => 16, 'created_at' => now()],
                ['menu_side_id' => 1, 'menu_item_id' => 17, 'created_at' => now()],
                ['menu_side_id' => 2, 'menu_item_id' => 17, 'created_at' => now()],
                ['menu_side_id' => 1, 'menu_item_id' => 18, 'created_at' => now()],
                ['menu_side_id' => 2, 'menu_item_id' => 18, 'created_at' => now()],
                ['menu_side_id' => 1, 'menu_item_id' => 19, 'created_at' => now()],
                ['menu_side_id' => 2, 'menu_item_id' => 19, 'created_at' => now()],
            ]
        );
    }
}
