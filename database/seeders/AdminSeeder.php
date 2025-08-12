<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Add this import

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@ppdb.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        // Create Admin Operator
        User::create([
            'name' => 'Admin Operator',
            'email' => 'operator@ppdb.com',
            'password' => Hash::make('operator123'),
            'email_verified_at' => now(),
        ]);

        // Create Admin Staff
        User::create([
            'name' => 'Admin Staff',
            'email' => 'staff@ppdb.com',
            'password' => Hash::make('staff123'),
            'email_verified_at' => now(),
        ]);
    }
}