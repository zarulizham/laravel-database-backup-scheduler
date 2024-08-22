<?php

namespace ZarulIzham\DatabaseBackup\Commands;

use Illuminate\Console\Command;
use ZarulIzham\DatabaseBackup\Facades\DatabaseBackup;

class DatabaseBackupCommand extends Command
{
    public $signature = 'database:backup';

    public $description = 'Backup database';

    public function handle(): int
    {
        $connections = config('database-backup-scheduler.connections');

        foreach ($connections as $connectionName => $data) {
            $this->info("Backup for $connectionName");
            DatabaseBackup::backup($connectionName, $data);
        }

        $this->info('All connection has been executed. Check database for more info.');

        return self::SUCCESS;
    }
}
