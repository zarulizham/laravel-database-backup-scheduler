<?php

namespace ZarulIzham\DatabaseBackup\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use ZarulIzham\DatabaseBackup\Enums\DatabaseBackupStatus;

class DatabaseBackup extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'connection',
        'status',
        'failed_reason',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => DatabaseBackupStatus::class,
    ];
}
