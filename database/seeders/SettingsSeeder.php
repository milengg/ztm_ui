<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serialCode = strtoupper(substr(md5(microtime()),rand(0,26),6));
        $settings = [
            [
                'parameter_name'    => 'envm.window_tamper.activations',
                'parameter_value'   => '0'
            ],
            [
                'parameter_name'    => 'envm.door_tamper.activations',
                'parameter_value'   => '0'
            ],
            [
                'parameter_name'    => 'envm.pir.activations',
                'parameter_value'   => '0'
            ],
            [
                'parameter_name'    => 'serial_number',
                'parameter_value'   => $serialCode
            ],
            [
                'parameter_name'    => 'admin_pin',
                'parameter_value'   => '1234'
            ],
            [
                'parameter_name'    => 'reset_pin',
                'parameter_value'   => '7777'
            ],
            [
                'parameter_name'    => 'tablet_locking_time',
                'parameter_value'   => '10'
            ],
            [
                'parameter_name'    => 'tablet_screensaver_time',
                'parameter_value'   => '60'
            ],
            [
                'parameter_name'    => 'mode',
                'parameter_value'   => 'client'
            ],
            [
                'parameter_name'    => 'updater_version',
                'parameter_value'   => 'none'
            ]
        ];
        Settings::insert($settings);
    }
}
