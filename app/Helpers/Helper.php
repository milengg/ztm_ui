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

if (! function_exists('bgDate')) {
    function bgDate($format)
    { 
        $date = date($format);
        $locale = ['Jan' => 'ЯНУАРИ', 'Feb' => 'ФЕВРУАРИ', 'Mar' => 'МАРТ', 'Apr' => 'АПРИЛ', 'May' => 'МАЙ', 'Jun' => 'ЮНИ', 'Jul' => 'ЮЛИ', 'Aug' => 'АВГУСТ', 'Sep' => 'СЕПТЕМВРИ', 'Oct' => 'ОКТОМВРИ', 'Nov' => 'НОЕМВРИ', 'Dec' => 'ДЕКЕМВРИ'];
        return str_replace(array_keys($locale), array_values($locale), $date);
    }
}