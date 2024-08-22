<?php

namespace ZarulIzham\DatabaseBackup\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ZarulIzham\DatabaseBackup\DatabaseBackup
 */
class DatabaseBackup extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ZarulIzham\DatabaseBackup\DatabaseBackup::class;
    }
}
