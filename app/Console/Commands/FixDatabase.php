<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class FixDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix database issues by creating all necessary tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Database Fix Tool');
        $this->info('===================');
        $this->info('');
        
        // Baca konfigurasi database
        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");
        
        $this->info("Current connection: {$connection}");
        $this->info("Database name: {$database}");
        $this->info('');
        
        if ($connection === 'mysql') {
            $this->fixMysql($database);
        } elseif ($connection === 'sqlite') {
            $this->fixSqlite($database);
        } else {
            $this->error("Unsupported connection type: {$connection}");
            return 1;
        }
        
        return 0;
    }
    
    /**
     * Fix MySQL database issues
     */
    protected function fixMysql($database)
    {
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $charset = config('database.connections.mysql.charset', 'utf8mb4');
        $collation = config('database.connections.mysql.collation', 'utf8mb4_unicode_ci');
        
        try {
            // Langkah 1: Koneksi ke server MySQL
            $this->info('Step 1: Connecting to MySQL server...');
            
            $pdo = new PDO(
                "mysql:host={$host};port={$port}",
                $username,
                $password
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->info('Connected successfully to MySQL server.');
            
            // Langkah 2: Buat database jika belum ada
            $this->info("Step 2: Creating database '{$database}' if not exists...");
            
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET {$charset} COLLATE {$collation}");
            
            $this->info("Database '{$database}' created successfully.");
            
            // Langkah 3: Koneksi ke database yang baru dibuat
            $this->info("Step 3: Connecting to '{$database}' database...");
            
            $pdo = new PDO(
                "mysql:host={$host};port={$port};dbname={$database}",
                $username,
                $password
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->info("Connected successfully to '{$database}' database.");
            
            // Langkah 4: Buat tabel migrations secara manual
            $this->info('Step 4: Creating migrations table manually...');
            
            $sql = "
                CREATE TABLE IF NOT EXISTS `migrations` (
                  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `migration` varchar(255) NOT NULL,
                  `batch` int(11) NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            $pdo->exec($sql);
            
            $this->info('Migrations table created successfully.');
            
            // Langkah 5: Jalankan migrasi dengan --force
            $this->info('Step 5: Running migrations...');
            
            $this->call('migrate', ['--force' => true]);
            
            // Langkah 6: Populate data dengan seeder
            $this->info('Step 6: Running seeders...');
            
            $this->call('db:seed', ['--force' => true]);
            
            $this->info('');
            $this->info('✅ Database setup completed successfully!');
            $this->info('You can now access your application.');
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
    
    /**
     * Fix SQLite database issues
     */
    protected function fixSqlite($database)
    {
        try {
            $databasePath = database_path($database);
            $this->info("Step 1: Creating SQLite database at {$databasePath}...");
            
            if (!file_exists(dirname($databasePath))) {
                mkdir(dirname($databasePath), 0755, true);
            }
            
            if (!file_exists($databasePath)) {
                touch($databasePath);
                $this->info("SQLite database file created.");
            } else {
                $this->info("SQLite database file already exists.");
            }
            
            $this->info("Step 2: Running migrations...");
            $this->call('migrate', ['--force' => true]);
            
            $this->info("Step 3: Running seeders...");
            $this->call('db:seed', ['--force' => true]);
            
            $this->info('');
            $this->info('✅ Database setup completed successfully!');
            $this->info('You can now access your application.');
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
} 