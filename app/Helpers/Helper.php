<?php

use App\Models\Settings;

if (! function_exists('checkMode')) {
    function checkMode()
    { 
        $mode = Settings::where('parameter_name', 'mode')->first();
        if($mode === null)
        {
            return 'unknown';   
        } else {
            return $mode->parameter_value;
        }
    }
}