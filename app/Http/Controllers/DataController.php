<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Register;
use App\Models\Value;

class DataController extends Controller
{
    public function registers(Request $request)
    {
        $register_name = $request->input('reg_values')["register_name"];
        $register_value = $request->input('reg_values')["value"];
        
        $checkRegister = Register::where('name', $register_name)->first();
        $checkValue = Value::where('name', $register_name)->first();
        if($checkRegister)
        {
            if($checkValue)
            {
                $checkValue->update(['value' => $register_value]);
                return response()->json(['success' => 'success'], 200);
            }else{
                Value::create([
                    'register_id' => $checkRegister->id,
                    'name' => $checkRegister->name,
                    'value' => $register_value
                ]);
                return response()->json(['success' => 'success'], 200);
            }
        }else{
            return response()->json(['not found' => 'success'], 404);
        }
    }
}
