<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Value;

class ValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Value::truncate();
        $values = [
            [
                'id' => 1,
                'register_id' => 77,
                'name' => 'hvac.temp_1.adjust',
                'value' => 0
            ],
            [
                'id' => 2,
                'register_id' => 36,
                'name' => 'blinds.blind_1.position',
                'value' => 0
            ],
            [
                'id' => 3,
                'register_id' => 110,
                'name' => 'light.target_illum',
                'value' => 0
            ],
            [
                'id' => 4,
                'register_id' => 256,
                'name' => 'vent.op_setpoint_1',
                'value' => 0
            ],
        ];
        Value::insert($values);
    }
}
