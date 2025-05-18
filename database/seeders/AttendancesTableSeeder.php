<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = \App\Models\User::where('role', 'student')->get();
        $teachers = \App\Models\User::where('role', 'teacher')->get();
        
        // Jika tidak ada student atau teacher, buat dulu
        if ($students->isEmpty()) {
            // Buat student
            $student = \App\Models\User::create([
                'name' => 'Student Demo',
                'email' => 'student@bimbelalfarizqi.com',
                'password' => bcrypt('student123'),
                'role' => 'student',
                'phone' => '081234567893',
                'address' => 'Jl. Pendidikan No.126, Balikpapan',
            ]);
            
            $students = collect([$student]);
        }
        
        if ($teachers->isEmpty()) {
            // Jika tidak ada teacher, gunakan teacher dari UsersTableSeeder
            $teachers = \App\Models\User::where('role', 'teacher')->get();
            
            // Jika masih kosong, buat teacher baru
            if ($teachers->isEmpty()) {
                $teacher = \App\Models\User::where('email', 'guru@bimbelalfarizqi.com')->first();
                
                if (!$teacher) {
                    $teacher = \App\Models\User::create([
                        'name' => 'Teacher Demo',
                        'email' => 'teacher@bimbelalfarizqi.com',
                        'password' => bcrypt('teacher123'),
                        'role' => 'teacher',
                        'phone' => '081234567894',
                        'address' => 'Jl. Pendidikan No.127, Balikpapan',
                    ]);
                }
                
                $teachers = collect([$teacher]);
            }
        }
        
        // Membuat 10 record attendance untuk bulan ini
        for ($i = 0; $i < 10; $i++) {
            $student = $students->random();
            $teacher = $teachers->random();
            
            $date = now()->subDays(rand(0, 30));
            
            \App\Models\Attendance::create([
                'student_id' => $student->id,
                'teacher_id' => $teacher->id,
                'date' => $date->format('Y-m-d'),
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'status' => 'present',
                'notes' => 'Pertemuan ke-' . ($i + 1),
                'meeting_type' => 'regular',
                'location' => 'Ruang Belajar ' . rand(1, 5),
            ]);
        }
    }
}
