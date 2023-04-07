<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Updates;

class ExecuteUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'execute-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates over selected distribution software';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $updates = Updates::all();
        
        foreach($updates as $update)
        {
            if($update->status === true)
            {
                $this->info($update->service . ' е предвиден да ъпдейт...');
            } else {
                $this->error($update->service . ' не е предвиден за ъпдейт!');
            }
        }
    }
}
