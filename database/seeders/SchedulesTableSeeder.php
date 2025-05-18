<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Program;
use Carbon\Carbon;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah jadwal sudah ada
        if (Schedule::count() > 0) {
            return;
        }

        // Cek apakah ada guru
        $teachers = User::where('role', 'teacher')->get();
        if ($teachers->isEmpty()) {
            $this->command->info('Tidak ada guru untuk dibuat jadwal. Silahkan buat guru terlebih dahulu.');
            return;
        }

        // Cek apakah ada siswa
        $students = User::where('role', 'student')->get();
        if ($students->isEmpty()) {
            $this->command->info('Tidak ada siswa untuk dibuat jadwal. Silahkan buat siswa terlebih dahulu.');
            return;
        }

        // Ambil program yang tersedia
        $programs = Program::all();
        if ($programs->isEmpty()) {
            $this->command->info('Tidak ada program untuk dibuat jadwal. Silahkan buat program terlebih dahulu.');
            return;
        }

        // Buat jadwal untuk 2 minggu ke depan
        $locations = ['Ruang Belajar 1', 'Ruang Belajar 2', 'Ruang Belajar 3', 'Online (Zoom)', 'Rumah Siswa'];
        $statuses = ['scheduled', 'completed', 'cancelled', 'postponed'];
        
        // Jadwal siswa untuk beberapa hari ke depan
        for ($day = 0; $day < 14; $day++) {
            $date = Carbon::today()->addDays($day);
            
            // 3-5 jadwal per hari
            $dailySchedules = rand(3, 5);
            
            for ($i = 0; $i < $dailySchedules; $i++) {
                $startHour = rand(8, 16); // Jadwal jam 8 pagi sampai 4 sore
                $duration = rand(1, 2); // Durasi 1-2 jam
                
                $student = $students->random();
                $teacher = $teachers->random();
                $program = $programs->random();
                
                Schedule::create([
                    'student_id' => $student->id,
                    'teacher_id' => $teacher->id,
                    'program_id' => $program->id,
                    'date' => $date->format('Y-m-d'),
                    'start_time' => sprintf('%02d:00:00', $startHour),
                    'end_time' => sprintf('%02d:00:00', $startHour + $duration),
                    'title' => $program->name . ' - ' . $student->name,
                    'description' => 'Sesi belajar ' . $program->name . ' untuk ' . $student->name,
                    'location' => $locations[array_rand($locations)],
                    'status' => $day < 2 ? 'scheduled' : $statuses[array_rand($statuses)],
                    'notes' => 'Catatan: Siswa diharapkan membawa buku dan alat tulis',
                    'is_recurring' => (bool)rand(0, 1),
                    'recurrence_pattern' => rand(0, 1) ? 'weekly' : null,
                ]);
            }
        }
        
        $this->command->info('Berhasil membuat ' . Schedule::count() . ' jadwal pembelajaran.');
    }
}
