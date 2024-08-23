<?php

namespace ZarulIzham\DatabaseBackup\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use ZarulIzham\DatabaseBackup\Models\DatabaseBackup;

class PruneBackupCommand extends Command
{
    public $signature = 'db:backup:prune {--days=14}';

    public $description = 'Delete old backups';

    public function handle(): int
    {
        $date = Carbon::now()->subDays($this->option('days'));

        $databaseBackups = DatabaseBackup::query()
            ->where('created_at', '<=', $date)
            ->get();

        $this->info('Total backups: '.$databaseBackups->count());

        foreach ($databaseBackups as $databaseBackup) {
            foreach ($databaseBackup->getMedia('*') as $media) {
                $media->delete();
            }

            $databaseBackup->delete();
        }

        return self::SUCCESS;
    }
}
