<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FixMigrations extends Command
{
    protected $signature = 'fix:migrations';
    protected $description = 'Fix migrations and create default users';

    public function handle()
    {
        $this->info('Fixing migrations...');

        // Drop all tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            DB::statement("DROP TABLE IF EXISTS `$tableName`");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Create users table
        DB::statement('
            CREATE TABLE IF NOT EXISTS users (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NULL,
                email_verified_at TIMESTAMP NULL,
                password VARCHAR(255) NULL,
                role ENUM("admin", "teacher", "parent", "student") DEFAULT "parent",
                phone VARCHAR(255) NULL,
                address TEXT NULL,
                parent_id BIGINT UNSIGNED NULL,
                parent_email VARCHAR(255) NULL,
                program ENUM("CaLisTung", "Matematika", "Bahasa Inggris", "Hijaiyah", "Mata Pelajaran SD", "IPA SD", "Bahasa Indonesia SD") NULL,
                grade VARCHAR(255) NULL,
                birthdate DATE NULL,
                teacher_id BIGINT UNSIGNED NULL,
                remember_token VARCHAR(100) NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                FOREIGN KEY (parent_id) REFERENCES users(id) ON DELETE SET NULL,
                FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ');

        // Create default users
        DB::table('users')->insert([
            [
                'name' => 'Admin SIBI',
                'email' => 'admin@bimbelalfarizqi.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Jl. Admin No. 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Orang Tua SIBI',
                'email' => 'ortu@bimbelalfarizqi.com',
                'password' => Hash::make('password123'),
                'role' => 'parent',
                'phone' => '081234567891',
                'address' => 'Jl. Orang Tua No. 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guru SIBI',
                'email' => 'guru@bimbelalfarizqi.com',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'phone' => '081234567892',
                'address' => 'Jl. Guru No. 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->info('Migrations fixed and default users created!');
        $this->info('You can now login with:');
        $this->info('Admin: admin@bimbelalfarizqi.com / password123');
        $this->info('Parent: ortu@bimbelalfarizqi.com / password123');
        $this->info('Teacher: guru@bimbelalfarizqi.com / password123');
    }
} 
 
 
 
 
 
 