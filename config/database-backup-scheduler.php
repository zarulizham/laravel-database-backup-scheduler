<?php

// config for ZarulIzham/DatabaseBackup
return [
    'connections' => [
        'mysql' => [
            'excludeTables' => [],
            'storage' => env('FILESYSTEM_DISK', 'local'),
        ],
    ],
];
