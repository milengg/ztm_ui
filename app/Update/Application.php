<?php

namespace App\Update;

class Application 
{
    /**
	 * Application version
	 *
	 * @var string
	 */
	protected static $version = null;

    /**
	 * Get application version
	 *
	 * @return string
	 */
	public static function version($reload = false)
	{
		//Check for cached version
		if(!is_null(self::$version) && !$reload)
		{
			//Return cached version
			return self::$version;
		}
		//Get version file location
		$version_file = rtrim(base_path(), '/') . '/.version';
		//Check for version file
		if(file_exists($version_file))
		{
			//Cache version number
			self::$version = file_get_contents($version_file);
		}
		else
		{
			//Default
			self::$version = '2.0.0';
		}
        
		//Return version number
		return self::$version;
	}
}