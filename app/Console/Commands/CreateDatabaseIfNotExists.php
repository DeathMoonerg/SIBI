<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;

class CreateDatabaseIfNotExists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create database if not exists';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = config('database.connections.mysql.database');
        $charset = config('database.connections.mysql.charset', 'utf8mb4');
        $collation = config('database.connections.mysql.collation', 'utf8mb4_unicode_ci');

        try {
            $this->info("Creating database '{$database}'...");
            
            $pdo = new PDO(
                'mysql:host=' . config('database.connections.mysql.host') . ';port=' . config('database.connections.mysql.port'),
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password')
            );
            
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET {$charset} COLLATE {$collation}");
            
            $this->info("Database '{$database}' created successfully!");
            
            // Buat tabel migrations secara manual untuk menghindari error array to string conversion
            $this->info("Creating migrations table manually...");
            
            $migrationsTable = "
                CREATE TABLE IF NOT EXISTS `{$database}`.`migrations` (
                  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `migration` varchar(255) NOT NULL,
                  `batch` int(11) NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            $pdo->exec($migrationsTable);
            $this->info("Migrations table created successfully!");
            
            // Jalankan migrasi dengan --force untuk mengabaikan konfirmasi
            $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Failed to create database: " . $e->getMessage());
            return 1;
        }
    }
} 