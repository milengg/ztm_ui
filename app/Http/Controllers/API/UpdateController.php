<?php

namespace App\Http\Controllers\API;

use App\Update\Application;
use Illuminate\Http\Request;

use App\Models\ServerSettings;

/**
 * Api controller
 */
class UpdateController extends BaseController
{
	/**
	 * Receive ping
	 *
	 * @param Request $request Request
	 *
	 * @return string
	 */
	public function receivePing(Request $request)
	{
		return $this->proxyRemote($request, function($place, $params, $request)
		{
			//Set distributable settings
			$distributable_settings = ['ztmUI', 'zoneID', 'zontromat'];
			
			//Check for version information
			if(isset($params['version']) && is_string($params['version']))
			{
				//Set place version info
				$place->version = $params['version'];
			}

			//Check for ip information
			if(isset($params['ip']) && is_string($params['ip']))
			{
				//Set place local ip address
				$place->ip = $params['ip'];
			}

			//Set place pinged at time
			$place->pinged_at = parse_date('now');
			//Save place
			$place->save();

			//Check for settings distribution
			if($place->first()->distribute_settings)
			{
				//Set distribution array
				$distribution = [];
				//Iterate distributable settings
				foreach($distributable_settings as $setting)
				{
					$distribution[$setting] = $place->getSetting($setting);
				}
				//Remove settings distribution
				$place->first()->update(['distribute_settings' => false]);
				//Return json distributed setting
				return json_encode($distribution);
			}
			
			//Return status
			return 'ok';
		});
	}

	/**
	 * Get current version
	 *
	 * @param Request $request Request
	 *
	 * @return string
	 */
	public function getVersion(Request $request)
	{
		return $this->proxyRemote($request, function()
		{
			return Application::version();
		});
	}

	/**
	 * Proxy remote request (decode & encode)
	 *
	 * @param Request  $request  Request
	 * @param callable $callback Callback function / Result
	 *
	 * @return string|null
	 */
	protected function proxyRemote(Request $request, $callback = null)
	{
		//Set place
		$place = null;
		//Read remote data
		$data = $this->readRemoteData($request, $place);
		//Check for data & place
		if(is_array($data) && !is_null($place))
		{
			//Call caclback
			$result = $callback($place, $data, $request);
			//Set encrypted
			$encrypted = null;
			//Increase timelimit
			set_time_limit(600);
			//Encode data with gzip
			$result = gzencode($result, 9);
			//Check for too big data
			if(strlen($result) > 10485760)
			{
				return ('@!@' . $result);
			}

			//Encrypt data
			if(ssl_encrypt($result, $encrypted, $place->private_key, 'private'))
			{
				return $encrypted;
			}
		}
		//Return null
		return abort(403);
	}

	/**
	 * Read remote data (crypted)
	 *
	 * @param Request $request Request
	 * @param Place   $place   Place
	 *
	 * @return array|null
	 */
	protected function readRemoteData(Request $request, Client &$place = null)
	{
		//Data array
		$data = [];
		//Get sync name
		$sync = $request->input('sync');
		//Check sync
		if($sync)
		{
			//Get all places
			$places = ServerSettings::all();
			//Iterate all places
			foreach($places as $c_place)
			{
				//Get current place private key
				$priv_key = $c_place->private_key;
				//Check for private key
				if(empty($priv_key)) continue;
				//Set decrypted sync
				$sync_decrypted = null;
				//Try to deccompress data
				if(openssl_private_decrypt($sync, $sync_decrypted, $priv_key))
				{
					//Check if place is valid
					if($sync_decrypted != 'zontromat') continue;
					//Check for place
					if($c_place instanceof ServerSettings)
					{
						//Set place
						$place = $c_place;
						//Get all input data
						$input = $request->all();
						//Iterate all inputs
						foreach($input as $key => $value)
						{
							//Set decrypted var
							$decrypted = null;
							//Try to decrypt input data
							if(ssl_decrypt($value, $decrypted, $priv_key, 'private'))
							{
								//Set decrypted input data
								$data[$key] = $decrypted;
							}
						}
						//Return data
						return $data;
					}
				}
			}
		}

		return abort(403);
	}
}