<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Update\Application;

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

    public function render()
    {
        $info = $this->info;
        return view('livewire.info', compact('info'));
    }
}
