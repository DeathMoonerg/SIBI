<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Periksa apakah pengguna sudah ada
        if (!User::where('email', 'admin@bimbelalfarizqi.com')->exists()) {
            // Admin
            User::create([
                'name' => 'Admin SIBI',
                'email' => 'admin@bimbelalfarizqi.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Jl. Pendidikan No.123, Balikpapan',
            ]);
        }

        if (!User::where('email', 'guru@bimbelalfarizqi.com')->exists()) {
            // Teacher
            User::create([
                'name' => 'Guru SIBI',
                'email' => 'guru@bimbelalfarizqi.com',
                'password' => Hash::make('guru123'),
                'role' => 'teacher',
                'phone' => '081234567891',
                'address' => 'Jl. Pendidikan No.124, Balikpapan',
            ]);
        }

        if (!User::where('email', 'ortu@bimbelalfarizqi.com')->exists()) {
            // Parent
            User::create([
                'name' => 'Orang Tua SIBI',
                'email' => 'ortu@bimbelalfarizqi.com',
                'password' => Hash::make('ortu123'),
                'role' => 'parent',
                'phone' => '081234567892',
                'address' => 'Jl. Pendidikan No.125, Balikpapan',
            ]);
        }
    }
} 