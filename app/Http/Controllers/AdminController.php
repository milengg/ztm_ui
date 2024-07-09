<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

use App\Models\Settings;
use App\Models\Log;
use App\Models\User;
use App\Models\Changelog;
use App\Models\ServerSettings;
use App\Models\ClientSettings;
use App\Models\ClientRequest;
use App\Models\Updates;
use App\Models\Group;
use App\Models\Value;

class AdminController extends Controller
{
	private $client_settings;

    public function __construct(ClientSettings $client_settings)
    {
		$this->client_settings = $client_settings;
    }

    public function unlockPin(Request $request)
    {
        $admin_pin = Settings::where('parameter_name', 'admin_pin')->first()->parameter_value;
        $reset_pin = Settings::where('parameter_name', 'reset_pin')->first()->parameter_value;
        $tablet_ip = Settings::where('parameter_name', 'tablet_ip')->first();
        if($request->input('pin_number') == $admin_pin)
        {
            if(!$tablet_ip)
            {
                Settings::create([
                    'parameter_name' => 'tablet_ip',
                    'parameter_value' => $this->client_settings->getIpAddress() ?? 0,
                    'bgerp_sync' => 0
                ]);
            } else {
                $tablet_ip->update([
                    'parameter_name' => 'tablet_ip',
                    'parameter_value' => $this->client_settings->getIpAddress() ?? 0,
                    'bgerp_sync' => 0
                ]);
            }
            Log::create([
                'action' => 'Админ пин приет',
                'action_value' => $admin_pin
            ]);
            $user = User::first();
            Auth::login($user);
            return response()->json(['success' => 'admin'], 200);
        } elseif($request->input('pin_number') == $reset_pin) {
            Log::create([
                'action' => 'Ресет пин приет',
                'action_value' => $reset_pin
            ]);
            return response()->json(['success' => 'reset'], 200);
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

    protected function collectionConverter($json, $identifier, $function)
    {
        $json_data = json_decode($json, true);
        $collection = collect($json_data);
        $state = $collection->get($identifier)[0][$function];
        return $state;
    }

    public function main()
    {
        $window_tamper = Value::where('name', 'envm.window_tamper.activations')->first();
        $window_tamper_state = $this->collectionConverter($window_tamper->value, 'WINT_1', 'state');
        $door_tamper = Value::where('name', 'envm.door_tamper.activations')->first();
        $door_tamper_state = $this->collectionConverter($door_tamper->value, 'DRT_1', 'state');
        $settings = Settings::paginate(7);
        return view('panel.index', compact('settings', 'window_tamper_state', 'door_tamper_state'));
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

        if($validated['parameter_name'] == 'hostname')
        {
            file_put_contents('/etc/hostname', $validated['parameter_value']);
            exec(sprintf('hostname "%s"', $validated['parameter_value']));
        }
        
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
        $groups = Group::all();
        return view('updates.add', compact('groups'));
    }

    public function create_server_settings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'server_name' => 'required',
            'server_ip' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.clients')->with(['error' => 'Възникна грешка!']);
        }

        $validated = $validator->validated();

        ClientSettings::create([
            'server_name' => $validated['server_name'],
            'server_ip' => $validated['server_ip'],
			'tablet_ip' => $this->client_settings->getIpAddress() ?? 0,
            'public_key' => $request->input('public_key')
        ]);

        return redirect()->route('admin.clients')->with(['message' => 'Настройки за сървър бяха добавени успешно!']);
    }

    public function create_tablet_settings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tablet_name' => 'required',
            'group_id' => 'required:integer',
            'floor' => 'required',
            'room' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.clients')->with(['error' => 'Възникна грешка!']);
        }

        $validated = $validator->validated();

        ServerSettings::create([
            'tablet_name' => $validated['tablet_name'],
            'group_id' => $validated['group_id'],
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

    public function groups()
    {
        $groups = Group::paginate(7);
        return view('panel.groups', compact('groups'));
    }

    public function add_group()
    {
        return view('panel.add_group');
    }

    public function edit_group($id)
    {
        $group = Group::find($id);
        return view('panel.edit_group', compact('group'));
    }

    public function update_group(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'id' => 'integer',
            'version' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.groups')->with(['error' => 'Възникна грешка!']);
        }

        $group = Group::find($id);
        $validated = $validator->validated();

        $group->update([
            'name' => $validated['name'],
            'version' => $validated['version']
        ]);

        return redirect()->route('admin.groups')->with(['message' => 'Групата е обновена успешно!']);
    }

    public function view_group($id)
    {
        $group = Group::find($id);
        $tablets = ServerSettings::where('group_id', $id)->paginate(7);
        return view('panel.view_group', compact('group','tablets'));
    }

    public function create_group(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'version' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.groups')->with(['error' => 'Възникна грешка!']);
        }

        $validated = $validator->validated();

        Group::create([
            'name' => $validated['name'],
            'version' => $validated['version']
        ]);

        return redirect()->route('admin.groups')->with(['message' => 'Групата е добавен успешно!']);
    }

    public function group_mass_update($id)
    {
        $tablets = ServerSettings::where('group_id', $id)->get();
        foreach($tablets as $tablet)
        {
            $tablet->update([
                'distribute_settings' => true
            ]);
        }

        return redirect()->route('admin.groups.view', $id)->with(['message' => 'Всички клиенти бяха маркирани успешно за ъпдейт!']);

    }

    public function delete_group($id)
    {
        $group = Group::find($id);
        $group->delete();

        return redirect()->route('admin.groups')->with(['message' => 'Групата е изтрита успешно!']);
    }

    public function automatic_discovery()
    {
        $tablets = ClientRequest::where('response', '')->paginate(7);
        return view('updates/automatic_discovery', compact('tablets'));
    }

    public function automatic_discovery_add($serial)
    {
        $tablet = ClientRequest::find($serial);
        $groups = Group::all();
        return view('updates/add_automatic_discovery', compact('tablet', 'groups'));
    }

    public function automatic_discovery_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tablet_name' => 'required',
            'group_id' => 'integer',
            'floor' => 'required',
            'room' => 'required',
            'serial' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.automatic.discovery')->with(['error' => 'Възникна грешка!']);
        }

        $validated = $validator->validated();

        $client = ServerSettings::create([
            'tablet_name' => $validated['tablet_name'],
            'group_id' => $validated['group_id'],
            'floor' => $validated['floor'],
            'room'  => $validated['room']
        ]);

        $response = ClientRequest::find($validated['serial']);
        $response->update(['response' => $client->public_key]);

        return redirect()->route('admin.clients')->with(['message' => 'Таблета бе добавен успешно!']);
    }
}
