<?php

namespace App\Console\Commands;

use App\Update\Application;
use Illuminate\Console\Command;
use App\Models\ClientSettings;

/**
 * Make request
 */
class MakeRequest extends Command
{
	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make reuqest to server';

	/**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(!ClientSettings::first()->public_key)
        {
            //Create new updater
            $updater = Application::updater();
            //Set updater command
            $updater->setCommand($this);
            //Get mtime
            $mtime = microtime(true);
            //Ping accounting server
            if($updater->makeRequest())
            {
                //Set success info
                $this->info('Request success... (' . (microtime(true) - $mtime) . ')');
            }
            else
            {
                //Set error info
                $this->error('Request failed... (' . (microtime(true) - $mtime) . ')');
            }
        }
    }
}