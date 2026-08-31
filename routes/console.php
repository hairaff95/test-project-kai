<?php

use App\Console\Commands\AutoResetExpiredPasswordRequests;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jalankan auto-reset setiap jam — cek request yang sudah 24 jam belum diproses
Schedule::command(AutoResetExpiredPasswordRequests::class)->hourly();
