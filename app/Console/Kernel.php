<?php

namespace App\Console;

use App\Console\Commands\DeleteOldData;
use App\Http\Controllers\Users\AttendanceController;
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
        $schedule->call([AttendanceController::class, 'attendanceEvent'])->dailyAt('01:00');
        $schedule->command(DeleteOldData::class)->yearlyOn(7, 1, '01:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
