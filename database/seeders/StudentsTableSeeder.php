<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah data siswa sudah ada
        if (User::where('role', 'student')->count() > 0) {
            return;
        }

        // Cek apakah ada parent
        $parent = User::where('role', 'parent')->first();
        if (!$parent) {
            $this->command->info('Tidak ada parent yang ditemukan. Membuat parent baru...');
            $parent = User::create([
                'name' => 'Orang Tua SIBI',
                'email' => 'ortu@bimbelalfarizqi.com',
                'password' => Hash::make('ortu123'),
                'role' => 'parent',
                'phone' => '081234567892',
                'address' => 'Jl. Pendidikan No.125, Balikpapan',
            ]);
        }

        // Cek apakah ada guru
        $teacher = User::where('role', 'teacher')->first();
        if (!$teacher) {
            $this->command->info('Tidak ada guru yang ditemukan. Membuat guru baru...');
            $teacher = User::create([
                'name' => 'Guru SIBI',
                'email' => 'guru@bimbelalfarizqi.com',
                'password' => Hash::make('guru123'),
                'role' => 'teacher',
                'phone' => '081234567891',
                'address' => 'Jl. Pendidikan No.124, Balikpapan',
            ]);
        }

        // Data siswa
        $students = [
            [
                'name' => 'Ahmad Santoso',
                'email' => 'ahmad@contoh.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '08123456001',
                'address' => 'Jl. Pelajar No. 1, Balikpapan',
                'parent_id' => $parent->id,
                'teacher_id' => $teacher->id,
                'program' => 'CaLisTung',
                'grade' => 'Kelas 1 SD',
                'birthdate' => Carbon::now()->subYears(7)->format('Y-m-d'),
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 'siti@contoh.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '08123456002',
                'address' => 'Jl. Pelajar No. 2, Balikpapan',
                'parent_id' => $parent->id,
                'teacher_id' => $teacher->id,
                'program' => 'Matematika',
                'grade' => 'Kelas 2 SD',
                'birthdate' => Carbon::now()->subYears(8)->format('Y-m-d'),
            ],
            [
                'name' => 'Budi Santosa',
                'email' => 'budi@contoh.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '08123456003',
                'address' => 'Jl. Pelajar No. 3, Balikpapan',
                'parent_id' => $parent->id,
                'teacher_id' => $teacher->id,
                'program' => 'Bahasa Inggris',
                'grade' => 'Kelas 3 SD',
                'birthdate' => Carbon::now()->subYears(9)->format('Y-m-d'),
            ],
        ];

        foreach ($students as $studentData) {
            User::create($studentData);
        }

        $this->command->info('Berhasil menambahkan ' . count($students) . ' siswa baru.');
    }
}
