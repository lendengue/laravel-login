<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_user')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('password'),
                'email' => 'admin@example.com',
                'name' => 'Admin User',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'username' => 'john',
                'password' => Hash::make('secret'),
                'email' => 'john@example.com',
                'name' => 'John',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
