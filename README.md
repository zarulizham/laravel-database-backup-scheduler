# Automate and schedule your Laravel application database to your preferred storage filesystem


## Installation

You can install the package via composer:

```bash
composer require zarulizham/laravel-database-backup-scheduler
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="database-backup-scheduler-migrations"
php artisan migrate
```

This package relies on `spatie/media-library`. If your project did not use `spatie/media-library` package, publish its migration and/or config file.

```bash
php artisan vendor:publish --tag="medialibrary-config"
php artisan vendor:publish --tag="medialibrary-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="database-backup-scheduler-config"
```

This is the contents of the published config file. You may modify as per your needs.

```php
return [
    'connections' => [
        'mysql' => [
            'excludeTables' => [],
            'storage' => env('FILESYSTEM_DISK', 'local'),
        ],
    ],
];
```

## Usage

Place these two scheduler in `app/Console/Kernel.php` (<= Laravel 10) or `routes/console.php` (>= Laravel 11)
```php
$schedule->command('database:backup')->dailyAt('00:00')
    ->environments('production');

$schedule->command('database:backup:prune')->dailyAt('00:00')
    ->environments('production');
```

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Zarul Zubir](https://github.com/zarulizham)
- [All Contributors](../../contributors)
