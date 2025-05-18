<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
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
    protected $description = 'Create a new database based on .env DB_DATABASE';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $databaseName = config('database.connections.mysql.database');

        // Gunakan charset dan collation yang standard dan didukung secara luas
        $charset = 'utf8mb4';
        $collation = 'utf8mb4_unicode_ci';

        config(['database.connections.mysql.database' => null]);

        $query = "CREATE DATABASE IF NOT EXISTS `$databaseName` CHARACTER SET $charset COLLATE $collation;";

        DB::statement($query);

        config(['database.connections.mysql.database' => $databaseName]);

        $this->info("Successfully created database: $databaseName with charset $charset and collation $collation");
    }
} 