<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah data program sudah ada
        if (Program::count() > 0) {
            return;
        }

        $programs = [
            [
                'name' => 'CaLisTung',
                'description' => 'Program pembelajaran membaca, menulis dan berhitung',
                'duration' => '3 bulan',
                'level' => 'Pemula',
                'price' => 500000,
                'status' => 'active',
                'is_active' => true
            ],
            [
                'name' => 'Matematika',
                'description' => 'Program pembelajaran matematika dasar untuk anak SD',
                'duration' => '6 bulan',
                'level' => 'Dasar',
                'price' => 600000,
                'status' => 'active',
                'is_active' => true
            ],
            [
                'name' => 'Bahasa Inggris',
                'description' => 'Program pembelajaran bahasa Inggris untuk anak',
                'duration' => '6 bulan',
                'level' => 'Pemula',
                'price' => 650000,
                'status' => 'active',
                'is_active' => true
            ],
            [
                'name' => 'Hijaiyah',
                'description' => 'Program pembelajaran membaca Al-Quran',
                'duration' => '3 bulan',
                'level' => 'Pemula',
                'price' => 450000,
                'status' => 'active',
                'is_active' => true
            ],
            [
                'name' => 'Mata Pelajaran SD',
                'description' => 'Program bimbingan belajar untuk semua mata pelajaran SD',
                'duration' => '12 bulan',
                'level' => 'Semua Level',
                'price' => 800000,
                'status' => 'active',
                'is_active' => true
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
