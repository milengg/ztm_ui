<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Update\Application;
use App\Models\Settings;

class Info extends Component
{
    private $info;

    public function __construct()
    {
        $this->info = [
            'platform-version'  => strval(Application::version()),
            'php-version'       => strval(phpversion()),
            'tablet-ip'         => strval($_SERVER['SERVER_ADDR']),
            'curl-status'       => strval(function_exists('curl_version')),
            'os-core'           => strval(php_uname()),
            'framework'         => app()->version()
        ];
    }

    public function show_hostname()
    {
        $hostname = exec('hostname');
        if($hostname)
        {
            $settings = Settings::where('parameter_name', 'hostname')->first();
            if($settings)
            {
                $settings->update([
                    'parameter_value' => $hostname
                ]);
            } else {
                Settings::create([
                    'parameter_name' => 'hostname',
                    'parameter_value' => $hostname
                ]);
            }
            return $hostname;
        }
        return false;
    }

    public function render()
    {
        $hostname = $this->show_hostname();
        $info = $this->info;
        return view('livewire.info', compact('info', 'hostname'));
    }
}
