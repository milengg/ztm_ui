<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Update\Application;
use App\Models\Settings;


class PageController extends Controller
{
    public function index()
    {
        $version = strval(Application::version());
        $hostname = Settings::where('parameter_name', 'hostname')->first();
        return view('welcome', compact('version', 'hostname'));
    }
}
