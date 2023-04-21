<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;

use App\Models\Settings;
use App\Models\Log;
use App\Models\User;
use App\Models\Changelog;
use App\Models\ServerSettings;
use App\Models\ClientSettings;
use App\Models\Updates;

class AdminController extends Controller
{
	private $client_settings;

    public function __construct(ClientSettings $client_settings)
    {
		$this->client_settings = $client_settings;
    }

    public function unlockPin(Request $request)
    {
        $pin = Settings::where('parameter_name', 'pin')->first()->parameter_value;
        if($request->input('pin_number') == $pin)
        {
            Log::create([
                'action' => 'Пин приет',
                'action_value' => $pin
            ]);
            $user = User::first();
            Auth::login($user);
            return response()->json(['success' => 'Верен пин код'], 200);
        } else {
            Log::create([
                'action' => 'Пин отказан',
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

    public function main()
    {
        $settings = Settings::paginate(7);
        return view('panel.index', compact('settings'));
    }

    public function logs()
    {
        $logs = Log::paginate(7);
        return view('panel.logs', compact('logs'));
    }

    public function changelog(Request $request)
	{
        $contents = Changelog::all();
		return view('panel.changelog', compact('contents'));
	}

    public function settings_edit($id)
    {
        $parameter = Settings::find($id);
        return view('settings.edit_parameter', compact('parameter'));
    }

    public function settings_update(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'parameter_name' => 'required',
            'parameter_value' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.main')
                            ->withErrors($validator)
                            ->withInput();
        }

        $validated = $validator->validated();
        
        Settings::where('id', $id)->update([
            'parameter_name'  => $validated['parameter_name'],
            'parameter_value' => $validated['parameter_value']
        ]);

        return redirect()->route('admin.main')->with(['message' => 'Параметър бе редактиран успешно!']);
    }
    
    public function clients()
    {
        $tablets = ServerSettings::paginate(7);
        $servers = ClientSettings::paginate(7);

        return view('updates.index', compact('tablets', 'servers'));
    }

    public function add_client()
    {
        return view('updates.add');
    }

    public function create_server_settings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'server_name' => 'required',
            'server_ip' => 'required',
            'public_key' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.clients')->with(['error' => 'Възникна грешка!']);
        }

        $validated = $validator->validated();

        ClientSettings::create([
            'server_name' => $validated['server_name'],
            'server_ip' => $validated['server_ip'],
			'tablet_ip' => $this->client_settings->getIpAddress(),
            'public_key' => $validated['public_key']
        ]);

        return redirect()->route('admin.clients')->with(['message' => 'Настройки за сървър бяха добавени успешно!']);
    }

    public function create_tablet_settings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tablet_name' => 'required',
            'floor' => 'required',
            'room' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.clients')->with(['error' => 'Възникна грешка!']);
        }

        $validated = $validator->validated();

        ServerSettings::create([
            'tablet_name' => $validated['tablet_name'],
            'floor' => $validated['floor'],
            'room'  => $validated['room']
        ]);

        return redirect()->route('admin.clients')->with(['message' => 'Таблет добавен успешно!']);
    }

    public function updates_settings()
    {
        $updates = Updates::all();
        return view('updates.updates', compact('updates'));
    }

    public function updates_settins_store(Request $request)
    {
        $values = $request->input('update_service');
        foreach($values as $id => $value)
        {
            Updates::where('id', $id)->first()->update([
                'status' => $value
            ]);
        }
        return redirect()->route('admin.updates.settings')->with(['message' => 'Параметрите са обновени успешно!']);
    }

    public function updates_allowed(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Id is missing...',
            ], 401);
        }

        $id = $request->input('id');

        ServerSettings::where('id', $id)->first()->update([
            'distribute_settings' => true
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Success.'
        ], 200);
    }

    public function download_publickey($id)
    {
        $public_key = ServerSettings::findOrFail($id);
        $response = response($public_key->public_key, 200, [
            'Content-Type' => $public_key->mime_type,
            'Content-Disposition' => 'attachment; filename="tablet-' . $id . '' . $public_key->filename . '.txt"',
        ]);
    
        return $response;
    }

    public function delete_tablet($id)
    {
        $tablet = ServerSettings::findOrFail($id);
        $tablet->delete();

        return redirect()->route('admin.clients')->with(['message' => 'Таблет изтрит успешно!']);
    }

    public function delete_server($id)
    {
        $server = ClientSettings::findOrFail($id);
        $server->delete();

        return redirect()->route('admin.clients')->with(['message' => 'Сървър изтрит успешно!']);
    }

    public function maintenance_mode()
    {
        if(PHP_OS == 'WINNT')
        {
            return redirect()->route('admin.main')->with(['error' => 'Тази функция под windows не работи!']);
        } else {
            exec('/opt/maintenance_mode');
		}
    }
}
