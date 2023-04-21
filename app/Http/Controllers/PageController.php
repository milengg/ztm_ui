<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Update\Application;


class PageController extends Controller
{
    public function index()
    {
        $version = strval(Application::version());
        return view('welcome', compact('version'));
    }
}
