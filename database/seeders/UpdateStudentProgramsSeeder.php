<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UpdateStudentProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Available programs
        $programs = [
            'CaLisTung',
            'Matematika',
            'Bahasa Inggris',
            'Hijaiyah',
            'Mata Pelajaran SD'
        ];
        
        // Available grades
        $grades = [
            'TK-A',
            'TK-B',
            'SD Kelas 1',
            'SD Kelas 2',
            'SD Kelas 3',
            'SD Kelas 4',
            'SD Kelas 5',
            'SD Kelas 6'
        ];
        
        // Get all students
        $students = User::where('role', 'student')->get();
        
        // If no students, create some
        if ($students->isEmpty()) {
            // Get a teacher
            $teacher = User::where('role', 'teacher')->first();
            
            if (!$teacher) {
                $teacher = User::create([
                    'name' => 'Teacher Demo',
                    'email' => 'teacher@bimbelalfarizqi.com',
                    'password' => bcrypt('teacher123'),
                    'role' => 'teacher',
                    'phone' => '081234567894',
                    'address' => 'Jl. Pendidikan No.127, Balikpapan',
                ]);
            }
            
            // Create 5 students
            for ($i = 1; $i <= 5; $i++) {
                $student = User::create([
                    'name' => "Student {$i}",
                    'email' => "student{$i}@example.com",
                    'password' => bcrypt('student123'),
                    'role' => 'student',
                    'teacher_id' => $teacher->id,
                    'phone' => "08123456789{$i}",
                    'address' => "Jl. Pendidikan No.{$i}, Balikpapan",
                ]);
                
                $students->push($student);
            }
        }
        
        // Update each student with random program, grade, and birthdate
        foreach ($students as $student) {
            $program = $programs[array_rand($programs)];
            $grade = $grades[array_rand($grades)];
            
            // Random birthdate between 5-12 years ago
            $yearsAgo = rand(5, 12);
            $birthdate = Carbon::now()->subYears($yearsAgo)->subDays(rand(0, 365));
            
            $student->program = $program;
            $student->grade = $grade;
            $student->birthdate = $birthdate;
            $student->save();
            
            $this->command->info("Updated student {$student->name} with program: {$program}, grade: {$grade}");
        }
        
        $this->command->info('All students now have programs, grades, and birthdates.');
    }
}
