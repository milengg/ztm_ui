<?php

namespace App\Update;
use Illuminate\Console\Command;

use App\Models\ClientSettings;
use App\Models\Updates;
use App\Models\Settings;

class Updater extends Base 
{
    /**
	 * Sync url
	 *
	 * @var string
	 */
	public $sync_url = null;

    /**
	 * Sync key
	 *
	 * @var string
	 */
	public $pub_key = null;

    /**
	 * Update command
	 *
	 * @var Command
	 */
	protected $command = null;

	/**
	 * Obtain ip
	 * 
	 * @var string
	 */
	protected $obtain_ip = null;

	/**
	 * Obtain ip
	 * 
	 * @var string
	 */
	protected $tablet_serial_number = null;

    /**
	 * Constructor
	 */
	public function __construct()
	{
		//Get sync url
		$sync_url = ClientSettings::first()->server_ip ?? 'none';
		//Get public key
		$pub_key = ClientSettings::first()->public_key ?? 'none';

		
		//Check for key and url
		if($sync_url == 'none')
		{
			//Don't do anything
			return;
		}
		//Set sync url & pub key
		$this->sync_url = $sync_url;
		$this->pub_key = $pub_key;
		//Obtain ip
		$this->obtain_ip = ClientSettings::first()->tablet_ip ?? '127.0.0.1';
		$this->tablet_serial_number = Settings::where('parameter_name', 'serial_number')->first()->parameter_value ?? 'None';
	}

    /**
	 * Ping sync server
	 *
	 * @return bool
	 */
	public function ping()
	{
		//Get remote data
		$data = $this->getRemoteData('api.ping', ['version' => $this->getInstalledVersion(), 'ip' => $this->obtain_ip, 'serial_number' => $this->tablet_serial_number]);
		//Check for ping setting distribution
		if($this->pingSettingsDistribution($data)) return true;
		//Check for simple ping
		return ($data === 'ok');
	}

	/**
	 * Make request to server
	 *
	 * @return bool
	 */
	public function makeRequest()
	{
		if($row = Settings::where('parameter_name', 'serial_number')->first())
		{
			$serial = $row->parameter_value;
			if($clinet = ClientSettings::first())
			{
				$ip = $clinet->tablet_ip;	
			} else {
				$ip = '127.0.0.1';
			}
		} else {
			return false;
		}

		$data = $this->getUnencryptedRemoteData('api.request', ['serial' => $serial, 'ip' => $ip]);

		if($data !== 'ok' && strpos($data, '-----BEGIN PUBLIC KEY-----') === 0)
		{
			ClientSettings::first()->update(['public_key' => $data]);
			return true;
		}

		return ($data === 'ok');
	}

    /**
	 * Get current installed version
	 *
	 * @return string
	 */
	public function getInstalledVersion()
	{
		return Application::version();
	}

    /**
	 * Get available version
	 *
	 * @return string
	 */
	public function getAvailableVersion()
    {
		return $this->getRemoteData('api.version');
	}

    /**
	 * Set update command
	 *
	 * @param Command $command Command
	 *
	 * @return void
	 */
	public function setCommand(Command $command)
	{
		//Set command
		$this->command = $command;
	}

	/**
	 * Get unencrypted remote data
	 * 
	 * @param string     $route  Route
	 * @param array|null $params Parameters
	 * 
	 * @return string|null
	 */
	protected function getUnencryptedRemoteData($route, $params = null)
	{
		//Get remote url
		$remote_url = $this->getRemoteUrl($route);
		//Check for remote url
		if(is_null($remote_url))
		{
			return null;
		}

		//Create new curl request
		$ch = curl_init($remote_url);
		//Set curl options
		curl_setopt($ch, CURLOPT_URL, $remote_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//Execute request
		$result = curl_exec($ch);
		//Close curl connection
		curl_close($ch);

		//Return result
		return $result;
	}


    /**
	 * Ping settings distribution
	 *
	 * @param string $data Data
	 *
	 * @return bool
	 */
	protected function pingSettingsDistribution(string $data)
	{
		//Decode json data
		$array = json_decode($data, true);
		//Check for valid json data
		if(json_last_error() != JSON_ERROR_NONE) return false;
		//Check for valid array
		if(!is_array($array)) return false;
		
		//Iterate all settings for distribution
		foreach($array as $name => $value)
		{
			if($name == 'version')
			{
				Settings::where('parameter_name', 'updater_version')->first()->update(['parameter_value' => $value]);
			} else {
				$update_service = Updates::where('service', $name)->first();
				$update_service->update([
					'status' => $value
				]);
				if($update_service->status === true)
				{
					$update_service->update([
						'is_updated' => true
					]);
				}
			}
		}
		//Return success
		return true;
	}

	/**
	 * Get remote url
	 *
	 * @param string $route Route
	 *
	 * @return string|null
	 */
	protected function getRemoteUrl($route)
	{
		//Check for sync url
		if(is_null($this->sync_url))
		{
			return null;
		}
		//Get url from this release
		$route_url = route($route);
		//Parse sync url
		$sync_url_p = parse_url($this->sync_url);
		//Parse sync place url
		$route_url_p = parse_url($route_url);
		//Check for valid urls
		if(!is_array($sync_url_p) || !is_array($route_url_p))
		{
			return null;
		}
		//Add path to sync url
		$sync_url_p['path'] = $route_url_p['path'];
		//Buld new route url based on sync url
		return unparse_url($sync_url_p);
	}

	/**
	 * Get remote data
	 *
	 * @param string     $route  Route
	 * @param array|null $params Parameters
	 * 
	 * @return string|null
	 */
	protected function getRemoteData($route, $params = null)
	{
		//Check for public key
		if(is_null($this->pub_key))
		{
			return null;
		}

		//Get remote url
		$remote_url = $this->getRemoteUrl($route);
		//Check for remote url
		if(is_null($remote_url))
		{
			return null;
		}

		//Set encrypt sync
		$eSync = null;
		//Encrypt test sync data
		openssl_public_encrypt('zontromat', $eSync, $this->pub_key);
		//Create post content
		$post = array
		(
			'sync'	=> $eSync
		);
		
		//Check for params
		if(is_array($params))
		{
			foreach($params as $key => $value)
			{
				//Set encrypted var
				$encrypted = null;
				//Encrypt param value
				ssl_encrypt($value, $encrypted, $this->pub_key, 'public');
				//Add to post
				$post[$key] = $encrypted;
			}
		}

		//Create new curl request
		$ch = curl_init($remote_url);
		//Set curl options
		curl_setopt($ch, CURLOPT_URL, $remote_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//Execute request
		$result = curl_exec($ch);
		//Close curl connection
		curl_close($ch);

		//Set decrypted var
		$decrypted = null;

		//Check for unencrypted result
		if(strlen($result) > 2 && $result[0] == '@' && $result[1] == '!' && $result[2] == '@')
		{
			return gzdecode(substr($result, 3));
		}

		//Check for decryption
		if(ssl_decrypt($result, $decrypted, $this->pub_key, 'public'))
		{
			return gzdecode($decrypted);
		}

		return null;
	}

    /**
	 * Set info from update
	 *
	 * @param string $info Information
	 *
	 * @return void
	 */
	protected function info(string $info)
	{
		//Check for console command
		if(!is_null($this->command))
		{
			$this->command->info($info);
		}
	}

	/**
	 * Set error from update
	 *
	 * @param string $info Information
	 *
	 * @return void
	 */
	protected function error(string $info)
	{
		//Check for console command
		if(!is_null($this->command))
		{
			$this->command->error($info);
		}
	}
}