<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MaintenanceMode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance-mode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kill kiosk and run in maintenance mode...';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        exec('/opt/maintenance_mode');
    }
}
