<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class SyncSqliteToMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sync-sqlite-to-mysql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy all data from database.sqlite into MySQL kai_tracker';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sqlitePath = database_path('database.sqlite');
        if (!file_exists($sqlitePath)) {
            $this->error("File SQLite tidak ditemukan di {$sqlitePath}");
            return 1;
        }

        $this->info("Menghubungkan ke SQLite & MySQL...");

        $sqlite = new PDO("sqlite:{$sqlitePath}");
        $sqlite->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $mysqlHost = config('database.connections.mysql.host', '127.0.0.1');
        $mysqlPort = config('database.connections.mysql.port', '3306');
        $mysqlDb = config('database.connections.mysql.database', 'kai_tracker');
        $mysqlUser = config('database.connections.mysql.username', 'root');
        $mysqlPass = config('database.connections.mysql.password', '');

        $mysql = new PDO("mysql:host={$mysqlHost};port={$mysqlPort};dbname={$mysqlDb}", $mysqlUser, $mysqlPass);
        $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $mysql->exec('SET FOREIGN_KEY_CHECKS = 0;');

        $tables = [
            'users',
            'password_reset_tokens',
            'password_reset_requests',
            'sessions',
            'assets',
            'tenants',
            'contracts',
            'contract_financials',
            'monthly_schedules',
        ];

        foreach ($tables as $table) {
            $exists = $sqlite->query("SELECT name FROM sqlite_master WHERE type='table' AND name='{$table}'")->fetchColumn();
            if (!$exists) continue;

            $this->line("Menyinkronkan tabel: <info>{$table}</info>...");
            $mysql->exec("TRUNCATE TABLE `{$table}`");

            $stmt = $sqlite->query("SELECT * FROM \"{$table}\"");
            $rows = $stmt->fetchAll();

            if (empty($rows)) {
                $this->comment("  -> 0 baris");
                continue;
            }

            $columns = array_keys($rows[0]);
            $colList = implode(', ', array_map(fn($c) => "`{$c}`", $columns));
            $placeholders = implode(', ', array_fill(0, count($columns), '?'));
            $insertSql = "INSERT INTO `{$table}` ({$colList}) VALUES ({$placeholders})";
            $insertStmt = $mysql->prepare($insertSql);

            $count = 0;
            foreach ($rows as $row) {
                $insertStmt->execute(array_values($row));
                $count++;
            }
            $this->info("  -> {$count} baris berhasil disalin ke MySQL.");
        }

        $mysql->exec('SET FOREIGN_KEY_CHECKS = 1;');
        $this->info("\nSinkronisasi database.sqlite -> MySQL {$mysqlDb} SUKSES!");

        return 0;
    }
}
