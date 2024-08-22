<?php

namespace ZarulIzham\DatabaseBackup;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use ZarulIzham\DatabaseBackup\Commands\DatabaseBackupCommand;
use ZarulIzham\DatabaseBackup\Commands\PruneBackupCommand;

class DatabaseBackupServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-database-backup-scheduler')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_database_backups_table')
            ->hasCommands(DatabaseBackupCommand::class, PruneBackupCommand::class);
    }
}
