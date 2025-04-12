<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@app.com',
                'password' => bcrypt('12345678'),
                'is_admin' => true,
            ],
            [
                'name' => 'User',
                'email' => 'user@app.com',
                'password' => bcrypt('12345678'),
                'is_admin' => false,
            ],
        ]);
    }
}
