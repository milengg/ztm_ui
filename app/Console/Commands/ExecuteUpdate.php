<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

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
                $this->info($update->service . ' е предвиден за ъпдейт...');
                $this->info('Ъпдейта започва обновяване...');
                if($update->service == 'ztmUI')
                {
                    if($update->is_updated === true)
                    {
                        exec('/opt/update_ztmUI_process');
                        $update->update(['is_updated' => false]);
                        Artisan::call('update:changelog', []);
                        $this->info('Ъпдейта приключи успешно!');
                    } else {
                        $this->error('Ъпдейта вече е минал!');
                    }
                }
            } else {
                $this->error($update->service . ' не е предвиден за ъпдейт!');
            }
        }
    }
}
