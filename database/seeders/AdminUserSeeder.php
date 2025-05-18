<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Bimbel',
            'email' => 'admin@bimbel.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Jl. Admin No. 1'
        ]);

        // Create teacher user
        $teacher = User::create([
            'name' => 'Guru Bimbel',
            'email' => 'guru@bimbel.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'phone' => '08123456788',
            'address' => 'Jl. Guru No. 1',
            'program' => 'Matematika'
        ]);

        // Create parent user
        $parent = User::create([
            'name' => 'Orang Tua',
            'email' => 'ortu@bimbel.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
            'phone' => '08123456787',
            'address' => 'Jl. Ortu No. 1'
        ]);

        // Create student user
        User::create([
            'name' => 'Siswa Bimbel',
            'email' => 'siswa@bimbel.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '08123456786',
            'address' => 'Jl. Siswa No. 1',
            'program' => 'Matematika',
            'parent_id' => $parent->id,
            'teacher_id' => $teacher->id
        ]);
    }
}
