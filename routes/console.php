<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\GenerateSalesReportsJob;

Schedule::job(new GenerateSalesReportsJob())
    ->everyTwoMinutes()
    ->withoutOverlapping(2);

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
