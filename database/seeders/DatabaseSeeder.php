<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'username' => 'admin1',
            'password' => bcrypt('admin1'),
            'phone' => '08123456789',
            'role' => 'admin',
        ]);
        \App\Models\User::create([
            'username' => 'user1',
            'password' => bcrypt('user1'),
            'phone' => '08976543121',
        ]);
    }
}
