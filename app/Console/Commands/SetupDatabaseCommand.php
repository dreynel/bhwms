<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use PDO;
use Exception;

class SetupDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bhwms:setup {--fresh : Drop all existing tables and re-seed clean demonstration data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize MySQL database, run migrations, and populate standard BHWMS seed data';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->output->title('Barangay Health Worker Management System (BHWMS) - Database Setup');

        $driver = config('database.default');
        $dbName = config("database.connections.{$driver}.database");
        $dbHost = config("database.connections.{$driver}.host");
        $dbPort = config("database.connections.{$driver}.port");
        $dbUser = config("database.connections.{$driver}.username");
        $dbPass = config("database.connections.{$driver}.password");

        $this->info("Database Engine: [{$driver}] on {$dbHost}:{$dbPort}");
        $this->info("Target Database: [{$dbName}]");
        $this->info("User Account:    [{$dbUser}]");
        $this->newLine();

        // 1. If using MySQL, verify connection and create database if missing
        if ($driver === 'mysql') {
            $this->comment('Step 1/3: Checking MySQL server connectivity & database creation...');
            try {
                $dsn = "mysql:host={$dbHost};port={$dbPort};charset=utf8mb4";
                $pdo = new PDO($dsn, $dbUser, $dbPass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 5,
                ]);

                $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
                $this->info(" [OK] Database '{$dbName}' is ready on MySQL server.");
            } catch (Exception $e) {
                $this->error(" [FAILED] Could not connect to MySQL server: " . $e->getMessage());
                $this->warn("Please check that MySQL service is running and verify DB_HOST/DB_PORT/DB_USERNAME/DB_PASSWORD in your .env file.");
                return 1;
            }
        }

        // 2. Ensure application key exists
        if (empty(config('app.key'))) {
            $this->comment('Generating application encryption key (APP_KEY)...');
            Artisan::call('key:generate', ['--force' => true], $this->output);
        }

        // 3. Run Migrations & Seeders
        $isFresh = $this->option('fresh');
        $this->newLine();
        $this->comment($isFresh ? 'Step 2/3: Executing migrate:fresh --seed...' : 'Step 2/3: Executing migrate --seed...');

        try {
            if ($isFresh) {
                Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true], $this->output);
            } else {
                Artisan::call('migrate', ['--seed' => true, '--force' => true], $this->output);
            }
            $this->info(' [OK] Migrations and database seeders executed successfully.');
        } catch (Exception $e) {
            $this->error(' [FAILED] Migration error: ' . $e->getMessage());
            return 1;
        }

        // 4. Print Summary & Ready Info
        $this->newLine();
        $this->comment('Step 3/3: System configuration summary:');
        $this->table(
            ['System Role', 'Email Login', 'Password', 'Assigned Purok / Scope'],
            [
                ['Punong Barangay (Admin)', 'admin@newlucena.gov.ph', 'password', 'Purok 1-7 / Poblacion'],
                ['Health Supervisor (Doctor)', 'supervisor@newlucena.gov.ph', 'password', 'Municipal Health Office'],
                ['BHW Worker 1 (Ana Garcia)', 'bhw1@newlucena.gov.ph', 'password', 'Purok 1 & Purok 2'],
                ['BHW Worker 2 (Maria Clara)', 'bhw2@newlucena.gov.ph', 'password', 'Purok 3 & Purok 4'],
                ['BHW Worker 3 (Juana Dela Cruz)', 'bhw3@newlucena.gov.ph', 'password', 'Purok 5'],
            ]
        );

        $this->newLine();
        $this->info('================================================================');
        $this->info('  BHWMS IS 100% CONFIGURED & READY FOR DEMO / DEFENSE!          ');
        $this->info('  Run: php artisan serve                                        ');
        $this->info('  Access: http://127.0.0.1:8000                                 ');
        $this->info('================================================================');

        return 0;
    }
}
