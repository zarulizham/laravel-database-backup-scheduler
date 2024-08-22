<?php

namespace ZarulIzham\DatabaseBackup\Enums;

enum DatabaseBackupStatus: int
{
    case PENDING = 0;
    case SUCCESS = 1;
    case FAILED = 2;
}
