<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Update\Application;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands =
	  [
		  Commands\PingAcc::class,
      Commands\ExecuteUpdate::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		  //Check if application is installed
		  if(Application::installed())
		  {
		  	//Ping accounting server - status (10 minutes)
		  	$schedule->command('ping-acc')->everyMinute();
		  	$schedule->command('execute-update')->everyMinute();
		  }
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
