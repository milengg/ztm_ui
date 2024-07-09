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
        $blinds_blind_2_position = Register::where('name', 'blinds.blind_2.position')->first();
        $blinds_blind_3_position = Register::where('name', 'blinds.blind_3.position')->first();
        $blinds_blind_4_position = Register::where('name', 'blinds.blind_4.position')->first();
        $light_target_illum = Register::where('name', 'light.target_illum')->first();
        $vent_op_setpoint_1 = Register::where('name', 'vent.op_setpoint_1')->first();
        $window_tamper = Register::where('name', 'envm.window_tamper.activations')->first();
        $door_tamper = Register::where('name', 'envm.door_tamper.activations')->first();
        $pir = Register::where('name', 'envm.pir.activations')->first();
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
                'register_id' => $blinds_blind_2_position->id,
                'name' => 'blinds.blind_2.position',
                'value' => 0
            ],
            [
                'id' => 4,
                'register_id' => $blinds_blind_3_position->id,
                'name' => 'blinds.blind_3.position',
                'value' => 0
            ],
            [
                'id' => 5,
                'register_id' => $blinds_blind_4_position->id,
                'name' => 'blinds.blind_4.position',
                'value' => 0
            ],
            [
                'id' => 6,
                'register_id' => $light_target_illum->id,
                'name' => 'light.target_illum',
                'value' => 0
            ],
            [
                'id' => 7,
                'register_id' => $vent_op_setpoint_1->id,
                'name' => 'vent.op_setpoint_1',
                'value' => 0
            ],
            [
                'id' => 8,
                'register_id' => $window_tamper->id,
                'name' => 'envm.window_tamper.activations',
                'value' => '{
                                "WINT_1": [
                                  {
                                    "ts": 1720444956,
                                    "state": false
                                  }
                                ]
                            }'
            ],
            [
                'id' => 9,
                'register_id' => $door_tamper->id,
                'name' => 'envm.door_tamper.activations',
                'value' => '{
                                "DRT_1": [
                                  {
                                    "ts": 1720444956,
                                    "state": false
                                  }
                                ]
                            }'
            ],
            [
                'id' => 10,
                'register_id' => $door_tamper->id,
                'name' => 'envm.pir.activations',
                'value' => 0
            ],
        ];
        Value::insert($values);
    }
}
