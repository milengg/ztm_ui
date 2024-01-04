<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Value;
use App\Models\Settings;
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
    public function index()
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

    public function update(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'min' => 'required',
            'max' => 'required',
            'status' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $id = Value::where('name', $input['name'])->first()->value('id');
        $value = Value::find($id);
        $value->min = $input['min'];
        $value->max = $input['max'];
        $value->status = $input['status'];
        $value->save();

        return $this->sendResponse(new ValueResource($value), 'Value updated successfully.');
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
}