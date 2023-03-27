<?php

use App\Models\Setting;

if (! function_exists('checkMode')) {
    function checkMode()
    { 
        $mode = Setting::where('parameter_name', 'mode')->first();
        if($mode === null)
        {
            return 'unknown';   
        } else {
            return $mode->parameter_value;
        }
    }
}