<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@sekna.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Professional users
        User::factory()->count(5)->create(['role' => 'professional']);

        // Public users
        User::factory()->count(10)->create(['role' => 'user']);
    }
}

