<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateStudentsWithTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all students
        $students = User::where('role', 'student')->get();
        
        // Get all teachers
        $teachers = User::where('role', 'teacher')->get();
        
        // If no teachers, create one
        if ($teachers->isEmpty()) {
            $teacher = User::create([
                'name' => 'Teacher Demo',
                'email' => 'teacher@bimbelalfarizqi.com',
                'password' => bcrypt('teacher123'),
                'role' => 'teacher',
                'phone' => '081234567894',
                'address' => 'Jl. Pendidikan No.127, Balikpapan',
            ]);
            
            $teachers = collect([$teacher]);
        }
        
        // Assign a random teacher to each student without a teacher_id
        foreach ($students as $student) {
            if (!$student->teacher_id) {
                $student->teacher_id = $teachers->random()->id;
                $student->save();
                
                $this->command->info("Assigned teacher to student: {$student->name}");
            }
        }
        
        $this->command->info('All students now have a teacher assigned.');
    }
}
