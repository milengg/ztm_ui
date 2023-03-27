<?php

namespace App\Update;

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
	 * Blocking file
	 *
	 * @var string
	 */
	protected $blocking_file = 'service.block';

    /**
	 * Update command
	 *
	 * @var Command
	 */
	protected $command = null;

    /**
	 * Constructor
	 */
	public function __construct()
	{
		//Get sync url
		$sync_url = setting('accounting-url');
		//Get public key
		$pub_key = setting('accounting-key');
		//Check for key and url
		if(empty($sync_url) || empty($pub_key))
		{
			//Don't do anything
			return;
		}
		//Set sync url & pub key
		$this->sync_url = $sync_url;
		$this->pub_key = $pub_key;
	}

    /**
	 * Ping sync server
	 *
	 * @return bool
	 */
	public function ping()
	{
		//Get remote data
		$data = $this->getRemoteData('api.ping', ['version' => $this->getInstalledVersion(), 'ip' => $this->getIpAddress()]);
		//Check for ping setting distribution
		if($this->pingSettingsDistribution($data)) return true;
		//Check for simple ping
		return ($data === 'ok');
	}

    /**
	 * Update application
	 *
	 * @param string $path Path to ZIP with files
	 *
	 * @return bool
	 */
	public function update(string $path = null, bool $force = false)
	{
		//Chek if updates are enabled
		if(config('app.updates') == false)
		{
			//Set error
			$this->error("Application updates are disabled! This is security feature for develop mode!");
			//Return false
			return false;
		}

		//Check for blocking
		if(Storage::exists($this->blocking_file) && Storage::lastModified($this->blocking_file) > time() - 3600)
		{
			//Set error
			$this->error("Application is currently blocked by other update or procedure!");
			//Return false
			return false;
		}

		//Check for lib sodium
		if(!defined('SODIUM_CRYPTO_SECRETBOX_NONCEBYTES'))
		{
			//Set error
			$this->error("Lib sodium is not installed or configured correctly! Update cannot be processed without it!");
			//Return false
			return false;
		}

		//Set success var
		$sucess = false;
		//Get blocking file path
		$blocking_file_path = Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix($this->blocking_file);
		//Touch blocking file
		touch($blocking_file_path);

		//Check for path
		if(is_null($path))
		{
			//Set download info
			$this->info('Downloading application update...');
			//Download and get available version file path
			$path = $this->downloadAvailableVersion();
		}

		//Check for valid file path
		if(!empty($path) && file_exists($path))
		{
			//Get update version
			$update_version = $this->getUpdateVersion($path);
			//Check if update version is newer
			if($this->isNewVersionAvailable(Application::version(), $update_version) || $force)
			{
				//Set information
				$this->info('Making system archive copy...');
				//Make whole system copy
				if($this->makeSystemCopy())
				{
					//Running before update procedures
					if($this->runUpdateProcedures('before'))
					{
						//Set information
						$this->info('Extracting update files...');
						//Extract update files
						if($this->extractUpdateFiles($path, true))
						{
							//Set information
							$this->info('Update configuration files...');
							//Update config files
							$this->updateConfigs();
							//Create requred storage paths
							$this->createStoragePaths();
							//Running after update procedures
							$this->runUpdateProcedures('after');
							//Clear update configuration
							$this->clearUpdateConfigurations();
							//Sucessed
							$sucess = true;
						}
						else
						{
							//Set error
							$this->error('Error occurred extraction update files. Update is canceled!');
						}
					}
					else
					{
						//Set error
						$this->error('Error occurred with before update procedures. Update is canceled!');
					}
				}
				else
				{
					//Set error
					$this->error('Error occurred while making system copy. Update is canceled!');
				}
			}
			else
			{
				//Set error
				$this->error('Your current version is newer than update package version. Update is canceled!');
			}
		}

		//Remove blocking file
		Storage::delete($this->blocking_file);
		//Return success
		return $sucess;
	}

	/**
	 * Get update version
	 *
	 * @param string $path Update path
	 *
	 * @return string|null
	 */
	public function getUpdateVersion(string $path = null)
	{
		//Check for update path
		if(is_null($path))
		{
			return $this->getAvailableVersion();
		}

		//Check if file exists
		if(file_exists($path))
		{
			//Create zip archive
			$zip = new ZipArchive();
			//Try to open path as zip
			if($zip->open($path) === true)
			{
				//Get version from archive
				$version = $zip->getFromName('.version');
				//Close archive
				$zip->close();
				//Check for valid version
				if(is_string($version))
				{
					//Return version
					return $version;
				}
			}
		}

		//No version
		return null;
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
	 * Is new version available
	 *
	 * @param string $currentVersion Current Version
	 *
	 * @return bool
	 */
	public function isNewVersionAvailable($currentVersion = '', $availableVersion = '')
    {
		//Get current installed version
		$version = $currentVersion ?: $this->getInstalledVersion();
		$a_version = $availableVersion ?: $this->getAvailableVersion();

		//Check for version
		if (!$version)
		{
            throw new \InvalidArgumentException('No currently installed version specified.');
        }

		//Compare two versions
		if (version_compare($version, $a_version, '<'))
		{
			return true;
		}

		return false;
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
	 * Get current ip address
	 *
	 * @return string
	 */
	protected function getIpAddress()
	{
		//Set var
		$ips = [];
		//Find all coresponsing ip addresses
		preg_match_all('/inet addr: ?([^ ]+)/', `ifconfig`, $ips);
		//Check for valid result
		if(is_array($ips) && isset($ips[1]) && is_array($ips[1]) && count($ips[1]) > 0)
		{
			//Iterate all ip addresses	
			foreach($ips[1] as $ip)
			{
				//Check for non-default
				if($ip !== '127.0.0.1') return $ip;
			}
		}
		else
		{
			//Find all coresponsing ip addresses - variant 2
			preg_match_all('/inet ?([^ ]+)/', `ifconfig`, $ips);
			//Check for valid result
			if(is_array($ips) && isset($ips[1]) && is_array($ips[1]) && count($ips[1]) > 0)
			{
				//Iterate all ip addresses	
				foreach($ips[1] as $ip)
				{
					//Check for non-default
					if($ip !== '127.0.0.1') return $ip;
				}
			}
		}
		//Return default local
		return '127.0.0.1';
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
			//Get current setting
			$setting = setting($name);
			//Check if setting exists & is different
			if(!is_null($setting) && $setting != $value)
			{
				//Set new setting value
				setting($name, $value);
			}
		}
		//Return success
		return true;
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