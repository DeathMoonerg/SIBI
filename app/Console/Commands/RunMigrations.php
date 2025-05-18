<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RunMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:manual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations manually by executing SQL directly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Running Manual Migrations');
        $this->info('=========================');
        
        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");
        
        $this->info("Connection: {$connection}");
        $this->info("Database: {$database}");
        $this->info('');
        
        // Buat tabel users jika belum ada
        $this->info('Creating users table...');
        DB::statement('
            CREATE TABLE IF NOT EXISTS users (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                email_verified_at TIMESTAMP NULL,
                password VARCHAR(255) NOT NULL,
                remember_token VARCHAR(100) NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                role ENUM("admin", "teacher", "parent", "student") DEFAULT "student",
                teacher_id BIGINT UNSIGNED NULL,
                phone VARCHAR(20) NULL,
                address TEXT NULL,
                parent_id BIGINT UNSIGNED NULL,
                program_id BIGINT UNSIGNED NULL,
                birth_date DATE NULL
            )
        ');
        
        // Buat tabel school_classes
        $this->info('Creating school_classes table...');
        DB::statement('
            CREATE TABLE IF NOT EXISTS school_classes (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL UNIQUE,
                description TEXT NOT NULL,
                age_range VARCHAR(255) NOT NULL,
                capacity INT NOT NULL,
                fee DECIMAL(10, 2) NOT NULL,
                schedule VARCHAR(255) NOT NULL,
                image VARCHAR(255) NULL,
                is_popular TINYINT(1) NOT NULL DEFAULT 0,
                sort_order INT NOT NULL DEFAULT 0,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        ');
        
        // Buat tabel teachers
        $this->info('Creating teachers table...');
        DB::statement('
            CREATE TABLE IF NOT EXISTS teachers (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                position VARCHAR(255) NOT NULL,
                bio TEXT NULL,
                image VARCHAR(255) NULL,
                facebook VARCHAR(255) NULL,
                twitter VARCHAR(255) NULL,
                instagram VARCHAR(255) NULL,
                linkedin VARCHAR(255) NULL,
                is_popular TINYINT(1) NOT NULL DEFAULT 0,
                sort_order INT NOT NULL DEFAULT 0,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        ');
        
        // Buat tabel testimonials
        $this->info('Creating testimonials table...');
        DB::statement('
            CREATE TABLE IF NOT EXISTS testimonials (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                role VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                avatar VARCHAR(255) NULL,
                rating INT NULL,
                is_active TINYINT(1) NOT NULL DEFAULT 1,
                sort_order INT NOT NULL DEFAULT 0,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        ');
        
        // Tambahkan semua migrasi ke tabel migrations
        $this->info('Recording migrations in migrations table...');
        
        $files = File::files(database_path('migrations'));
        $batch = 1;
        
        foreach ($files as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            
            DB::table('migrations')->insertOrIgnore([
                'migration' => $filename,
                'batch' => $batch
            ]);
        }
        
        $this->info('');
        $this->info('✅ Manual migration completed successfully!');
        
        // Tambahkan data admin
        $this->info('Creating admin user...');
        DB::table('users')->insertOrIgnore([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        $this->info('Admin user created with email: admin@example.com and password: password');
        
        return 0;
    }
} 