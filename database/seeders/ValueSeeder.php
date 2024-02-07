<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Value;
use App\Models\Register;

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

        $hvac_temp_adjust = Register::where('name', 'hvac.temp_1.adjust')->first();
        $blinds_blind_1_position = Register::where('name', 'blinds.blind_1.position')->first();
        $light_target_illum = Register::where('name', 'light.target_illum')->first();
        $vent_op_setpoint_1 = Register::where('name', 'vent.op_setpoint_1')->first();
        $values = [
            [
                'id' => 1,
                'register_id' => $hvac_temp_adjust->id,
                'name' => 'hvac.temp_1.adjust',
                'value' => 0
            ],
            [
                'id' => 2,
                'register_id' => $blinds_blind_1_position->id,
                'name' => 'blinds.blind_1.position',
                'value' => 0
            ],
            [
                'id' => 3,
                'register_id' => $light_target_illum->id,
                'name' => 'light.target_illum',
                'value' => 0
            ],
            [
                'id' => 4,
                'register_id' => $vent_op_setpoint_1->id,
                'name' => 'vent.op_setpoint_1',
                'value' => 0
            ],
        ];
        Value::insert($values);
    }
}
