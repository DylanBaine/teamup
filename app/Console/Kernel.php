<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\GenerateReport::class,
        Commands\GenerateRepository::class,
        Commands\GenerateJavascriptModel::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cron:create_reoccurring_tasks')->hourly();
        $schedule->command('cron:clean_files_dir')->dailyAt('1:00')->emailOutputTo('dylan.baine@yahoo.com');
        $schedule->command('cron:notify_users_of_started_and_due_tasks')->dailyAt('7:00')->emailOutputTo('dylan.baine@yahoo.com');
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
