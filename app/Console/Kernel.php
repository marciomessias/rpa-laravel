<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('rpa:download-file')->everyMinute();
        $schedule->command('rpa:table-data')->everyMinute();
        $schedule->command('rpa:submit-form')->everyMinute();
        $schedule->command('rpa:upload-file')->everyMinute();
        $schedule->command('notredame:demostrativo-pdf-to-csv')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
