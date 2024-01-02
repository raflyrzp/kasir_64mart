<?php

namespace App\Console;

use CleanupExpiredDiscounts;
use Illuminate\Support\Facades\Event;
// use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('diskon:cleanup')->dailyAt('02.54');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected $commands = [
        CleanupExpiredDiscounts::class,
    ];
}
