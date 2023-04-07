<?php

namespace App\Console\Commands;

use App\Update\Application;
use Illuminate\Console\Command;

/**
 * Release
 */
class PingAcc extends Command
{
	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ping-acc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ping accounting server';

	/**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Create new updater
		$updater = Application::updater();
		//Set updater command
		$updater->setCommand($this);
		//Get mtime
		$mtime = microtime(true);
		//Ping accounting server
		if($updater->ping())
		{
			//Set success info
			$this->info('Пинг успешен... (' . (microtime(true) - $mtime) . ')');
		}
		else
		{
			//Set error info
			$this->error('Пинг неуспешен... (' . (microtime(true) - $mtime) . ')');
		}
    }
}