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
            if($update->service == 'ztmUI')
            {
                $ztmUI = Updates::where('service', 'ztmUI')->first();
                if($ztmUI->is_updated == true)
                {
                    $this->info('ztmUI е предвиден за ъпдейт...');
                    $ztmUI->update(['is_updated' => false]);
                    exec('/opt/update_ztmUI');
                    $this->info('Ъпдейта приключи успешно!');
                } else {
                    $this->error('Ъпдейта вече е минал!');
                }
            } 
            if($update->service == 'zoneID') {
                $zoneID = Updates::where('service', 'zoneID')->first();
                if($zoneID->is_updated == true)
                {
                    $this->info('zoneID е предвиден за ъпдейт...');
                    $zoneID->update(['is_updated' => false]);
                    exec('/opt/update_zoneID');
                    $this->info('Ъпдейта приключи успешно!');
                } else {
                    $this->error('Ъпдейта вече е минал!');
                }
            } 
            if($update->service == 'zontromat') {
                $zontromat = Updates::where('service', 'zontromat')->first();
                if($zontromat->is_updated == true)
                {
                    $this->info('zontromat е предвиден за ъпдейт...');
                    $zontromat->update(['is_updated' => false]);
                    exec('/opt/update_zontromat');
                    $this->info('Ъпдейта приключи успешно!');
                } else {
                    $this->error('Ъпдейта вече е минал!');
                }
            }
        }
    }
}
