<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Make sure to import the User model
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create an admin user
        User::create([
            'name' => 'Super Admin User',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin@123'), // Use a secure password
            'role_id' => 1, // Admin role
        ]);
        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin@123'), // Use a secure password
            'role_id' => 2, // Admin role
        ]);

        // Create an editor user
        User::create([
            'name' => 'Editor User',
            'email' => 'editor@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('editor@123'), // Use a secure password
            'role_id' => 3, // Editor role
        ]);

        // Create an author user
        User::create([
            'name' => 'Author User',
            'email' => 'author@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('author@123'), // Use a secure password
            'role_id' => 4, // Author role
        ]);
    }
}