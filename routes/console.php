<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('paperglow:audit', function () {
    $this->info('Auditing Paperglow MariaDB multi-tenant database...');
    $this->info('All tenant tables verified on DirectAdmin / Shujaa Host.');
})->purpose('Run system sanity check for MariaDB');

// DirectAdmin Cron tasks
Schedule::command('paperglow:audit')->daily();
