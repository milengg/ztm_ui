<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Value;
use Validator;

use App\Http\Resources\ValueResource;

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
}