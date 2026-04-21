<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Website;
use App\Jobs\CheckWebsiteHealth;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule website health checks every minute
Schedule::call(function () {
    $websites = Website::all();
    
    foreach ($websites as $website) {
        // Check if it's time to check this website based on its check_interval
        $shouldCheck = !$website->last_checked_at || 
                      $website->last_checked_at->addSeconds($website->check_interval)->isPast();
        
        if ($shouldCheck) {
            CheckWebsiteHealth::dispatch($website);
        }
    }
})->everyMinute()->name('check-websites')->withoutOverlapping();

// Check for offline servers every 5 minutes
Schedule::command('servers:check-offline --threshold=5')
    ->everyFiveMinutes()
    ->name('check-offline-servers')
    ->withoutOverlapping();
