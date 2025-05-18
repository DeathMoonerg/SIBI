<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminUserSeeder::class,
            SchoolClassSeeder::class,
            TeacherSeeder::class,
            TestimonialSeeder::class,
            StudentsTableSeeder::class,
            ProgramsTableSeeder::class,
            SchedulesTableSeeder::class,
            AttendancesTableSeeder::class,
            UpdateStudentProgramsSeeder::class,
            DefaultUsersSeeder::class,
        ]);

        // Create default users
        User::factory()->admin()->create();
        User::factory()->parent()->create();
        User::factory()->teacher()->create();
    }
}
