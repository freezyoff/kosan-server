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
        //\App\Console\Commands\Kosan\Migrations\Install::class,
		//\App\Console\Commands\Kosan\Migrations\Uninstall::class,
		
		\App\Console\Commands\Mosquitto\Restart::class,
		\App\Console\Commands\Mosquitto\Reload::class,
		\App\Console\Commands\Mosquitto\AddUser::class,
		
		\App\Console\Commands\Kosan\KosanServer_Restart::class,
		\App\Console\Commands\Kosan\UpdateRegionTable::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
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
