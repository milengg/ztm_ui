<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'parameter_name' => 'pin',
                'parameter_value' => '1234'
            ],
            [
                'parameter_name' => 'tablet_locking_time',
                'parameter_value' => '10'
            ],
            [
                'parameter_name' => 'tablet_screensaver_time',
                'parameter_value' => '60'
            ],
            [
                'parameter_name' => 'mode',
                'parameter_value' => 'client'
            ]
        ];
        Setting::insert($settings);
    }
}
