<?php

namespace ZarulIzham\DatabaseBackup;

use Exception;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;
use Spatie\DbDumper\Databases\PostgreSql;
use ZarulIzham\DatabaseBackup\Enums\DatabaseBackupStatus;
use ZarulIzham\DatabaseBackup\Models\DatabaseBackup as DatabaseBackupModel;

class DatabaseBackup
{
    public $databaseBackup;

    public $localPath;

    public $backupData;

    public function backup($connection, $data)
    {
        $this->backupData = $data;

        $connectionData = config('database.connections.'.$connection);

        $this->databaseBackup = $this->createRecord($connection);

        $this->dump($connection, $connectionData);

        $this->store();
    }

    public function createRecord($connection)
    {
        return DatabaseBackupModel::create([
            'connection' => $connection,
        ]);
    }

    public function dump($connection, $connectionData)
    {
        $this->localPath = $this->getLocalPath($connection);

        try {
            if ($connectionData['driver'] == 'mysql') {
                $dumper = MySql::create();
            } elseif ($connectionData['driver'] == 'pgsql') {
                $dumper = PostgreSql::create();
            } else {
                throw new Exception('Connection did not support yet.');
            }

            $dumper->setDbName($connectionData['database'])
                ->setUserName($connectionData['username'])
                ->setPassword($connectionData['password'])
                ->setHost($connectionData['host'])
                ->setPort($connectionData['port']);

            if (isset($this->backupData['excludeTables'])) {
                $dumper->excludeTables($this->backupData['excludeTables']);
            }

            $dumper->dumpToFile($this->localPath);
        } catch (\Throwable $th) {
            $this->databaseBackup->update([
                'failed_reason' => $th->getMessage(),
                'status' => DatabaseBackupStatus::FAILED,
            ]);
        }
    }

    public function getLocalPath($connection)
    {
        $storagePath = storage_path('app/backup/').date('Y/m/');
        $filename = $connection.'_'.date('Ymd_His').'.sql';
        try {
            File::makeDirectory($storagePath, 0755, true, false);
        } catch (\Throwable $th) {
        }

        return $storagePath.$filename;
    }

    public function store()
    {
        try {
            $this->databaseBackup->addMedia($this->localPath)
                ->addCustomHeaders([
                    'ACL' => 'private',
                ])
                ->toMediaCollection('dump', $this->backupData['storage']);

            $this->databaseBackup->update([
                'status' => DatabaseBackupStatus::SUCCESS,
            ]);
        } catch (\Throwable $th) {
            $this->databaseBackup->update([
                'failed_reason' => $th->getMessage(),
                'status' => DatabaseBackupStatus::FAILED,
            ]);
        }
    }
}
