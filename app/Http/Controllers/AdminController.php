<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Update\Application;
use App\Models\Setting;
use App\Models\Log;
use App\Models\User;
use App\Models\Changelog;
use App\Models\Client;

class AdminController extends Controller
{

    private $info;

    public function __construct()
    {
        $this->info = [
            'platform-version'  => strval(Application::version()),
            'php-version'       => strval(phpversion()),
            'tablet-ip'         => strval($_SERVER['REMOTE_ADDR']),
            'curl-status'       => strval(function_exists('curl_version')),
            'os-core'           => strval(php_uname()),
            'framework'         => app()->version()
        ];
    }

    public function unlockPin(Request $request)
    {
        $pin = Setting::where('parameter_name', 'pin')->first()->parameter_value;
        if($request->input('pin_number') == $pin)
        {
            Log::create([
                'action' => 'Login accepted',
                'action_value' => $pin
            ]);
            $user = User::first();
            Auth::login($user);
            return response()->json(['success' => 'success'], 200);
        } else {
            Log::create([
                'action' => 'Login denied',
                'action_value' => $request->input('pin_number')
            ]);
            return response()->json(['error' => 'Грешен пин код'], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
    }
    
    public function settings()
    {
        $info = $this->info;
        
        $settings = Setting::paginate(6);
        return view('settings.index', compact('info', 'settings'));
    }

    public function settings_edit($id)
    {
        $info = $this->info;
        $parameter = Setting::find($id);
        return view('settings.edit_parameter', compact('info', 'parameter'));
    }

    public function settings_update(Request $request, $id)
    {
        Setting::where('id', $id)->update([
            'parameter_name'  => $request->input('parameter_name'),
            'parameter_value' => $request->input('parameter_value')
        ]);

        return redirect()->route('admin.index')->with(['message' => 'Параметър бе редактиран успешно!']);
    }

    public function logs()
    {
        
        $info = $this->info;
        $logs = Log::paginate(6);
        return view('settings.logs', compact('info', 'logs'));
    }

    public function runQt()
    {
        exec('/opt/kill_kiosk_run_qt');
    }

	public function changelog(Request $request)
	{
        $info = $this->info;
        $contents = Changelog::all();
		return view('settings.changelog', compact('info', 'contents'));
	}

    public function clients()
    {
        $clients = Client::paginate(6);
        $info = $this->info;
        return view('clients.index', compact('clients', 'info'));
    }
}
