<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin LAPAKIN',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'address' => 'Jl. Admin No. 1, Jakarta',
        ]);

        // Customer User
        User::create([
            'name' => 'Customer LAPAKIN',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'address' => 'Jl. Customer No. 123, Jakarta',
        ]);

        // Additional Test Users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'address' => 'Jl. Merdeka No. 123, Jakarta',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
            'address' => 'Jl. Sudirman No. 456, Bandung',
        ]);
    }
}
