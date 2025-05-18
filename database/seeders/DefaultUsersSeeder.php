<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultUsersSeeder extends Seeder
{
    public function run()
    {
        // Create Admin
        User::create([
            'name' => 'Admin SIBI',
            'email' => 'admin@bimbelalfarizqi.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1',
        ]);

        // Create Parent
        User::create([
            'name' => 'Orang Tua SIBI',
            'email' => 'ortu@bimbelalfarizqi.com',
            'password' => Hash::make('password123'),
            'role' => 'parent',
            'phone' => '081234567891',
            'address' => 'Jl. Orang Tua No. 1',
        ]);

        // Create Teacher
        User::create([
            'name' => 'Guru SIBI',
            'email' => 'guru@bimbelalfarizqi.com',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
            'phone' => '081234567892',
            'address' => 'Jl. Guru No. 1',
        ]);

        $this->command->info('Default users created successfully!');
    }
} 
 
 
 
 
 
 