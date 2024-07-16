<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Value;
use App\Models\Settings;
use App\Models\Register;
use Validator;

use App\Http\Resources\ValueResource;
use App\Http\Resources\SettingsResource;

class ValueController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegisters()
    {
        $values = Value::all();
        return $this->sendResponse(ValueResource::collection($values), 'Values retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function setRegisters(Request $request)
    {
        foreach($request->all() as $items)
        {
            $validator = Validator::make($items, [
                'name' => 'required',
                'value' => 'required',
                'min' => 'nullable',
                'max' => 'nullable',
                'status' => 'required'
            ]);
   
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }

            $register_id = Register::where('name', $items['name'])->first();
            if($register_id)
            {
                $register_id = $register_id->id;
            } else {
                return $this->sendError('Registers Error', 'No such register in database!');
            }
            
            $register = Value::where('name', $items['name'])->first();
            if($register)
            {
                $register->update([
                    'name' => $items['name'],
                    'value' => $items['value'],
                    'min' => $items['min'],
                    'max' => $items['max'],
                    'status' => $items['status']
                ]);
            } else {
                Value::create([
                    'register_id' => $register_id,
                    'name' => $items['name'],
                    'value' => $items['value'],
                    'min' => $items['min'],
                    'max' => $items['max'],
                    'status' => $items['status']
                ]);
            }
        }
        return $this->sendResponse('Registers operations:', 'Completed!');
    }

    public function getSettings()
    {
        $settings = Settings::all();
        return $this->sendResponse(SettingsResource::collection($settings), 'Settings retrieved successfully.');
    }

    public function setSettings(Request $request)
    {
        foreach($request->all() as $items)
        {
            $validator = Validator::make($items, [
                'parameter_name' => 'required',
                'parameter_value' => 'required',
                'bgerp_sync' => 'required'
            ]);
       
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
    
            $setting = Settings::where('parameter_name', $items['parameter_name'])->first();
            if($setting)
            {
                Settings::where('id', $setting->id)->update([
                    'parameter_name' => $items['parameter_name'],
                    'parameter_value' => $items['parameter_value'],
                    'bgerp_sync' => $items['bgerp_sync']
                ]);
            } else {
                Settings::create([
                    'parameter_name' => $items['parameter_name'],
                    'parameter_value' => $items['parameter_value'],
                    'bgerp_sync' => $items['bgerp_sync']
                ]);
            }
        }
        $status = Settings::where('parameter_name', $items['parameter_name'])->first();
        return $this->sendResponse(new SettingsResource($status), 'Settings refreshed successfully.');
    }

    public function weather_values()
    {
        $weather_values = Value::all();
        return response()->json($weather_values->keyBy('name'));
    }

    public function sync(Request $request)
    {
        foreach($request->all() as $items)
        {
            $validator = Validator::make($items, [
                'name' => 'required',
                'min' => 'nullable',
                'max' => 'nullable',
                'status' => 'required'
            ]);
   
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }

            $register_id = Register::where('name', $items['name'])->first();
            if($register_id)
            {
                $register_id = $register_id->id;
            } else {
                return $this->sendError('Registers Error', 'No such register in database!');
            }
            
            $register = Value::where('name', $items['name'])->first();
            if($register)
            {
                $register->update([
                    'name' => $items['name'],
                    'value' => $items['value'],
                    'min' => $items['min'],
                    'max' => $items['max'],
                    'status' => $items['status']
                ]);
            } else {
                Value::create([
                    'register_id' => $register_id,
                    'name' => $items['name'],
                    'value' => $items['value'],
                    'min' => $items['min'],
                    'max' => $items['max'],
                    'status' => $items['status']
                ]);
            }
        }
        $values = Value::all();
        return $this->sendResponse(ValueResource::collection($values), 'Sync is successful!');
    }
}