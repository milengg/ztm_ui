<?php

namespace App\Update;

/**
 * Update/Release base
 */
class Base
{

	/**
	 * Fnmatch compability fixed
	 *
	 * @param string $pattern Pattern
	 * @param string $string  String
	 *
	 * @return bool
	 */
	protected function fnmatch($pattern, $string)
	{
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' || !function_exists('fnmatch'))
		{
			return preg_match("#^".strtr(preg_quote($pattern, '#'), array('\*' => '.*', '\?' => '.', '\[' => '[', '\]' => ']'))."$#i", $string) > 0;
		}

		return fnmatch($pattern, $string);
	}

	/**
	 * Get new temp file path
	 *
	 * @return string
	 */
	protected function newTempFilePath()
	{
		$tmpHandle = tmpfile();
		$metaDatas = stream_get_meta_data($tmpHandle);
		$tmpFilename = $metaDatas['uri'];
		fclose($tmpHandle);
		return $tmpFilename;
	}

	/**
	 * Is file skippable
	 *
	 * @param string $path File path
	 *
	 * @return bool
	 */
	protected function isFileSkippable($path)
	{
		//Skip paths
		$skip_paths =
		[
			'.env', '.vs/*', '.git/*', '.idea/*', 'tmp/*', 'public/old/*', 'public/uploads/*', 'public/css/builds/*', 'public/js/builds/*', 'config/*',
			'storage/*', 'gourmet.phpproj', 'gourmet.phpproj.user', 'gourmet.sln', 'System Volume Information/*'
		];

		//Reinclude paths
		$reinclude_paths =
		[
			'config/update/*'
		];

		//Check for different directory separator
		if(DIRECTORY_SEPARATOR != '/')
		{
			//Create convert function
			$convert_fn = function($value)
			{
				return str_replace('/', DIRECTORY_SEPARATOR, $value);
			};
			//Convert all paths
			$skip_paths = array_map($convert_fn, $skip_paths);
			$reinclude_paths = array_map($convert_fn, $reinclude_paths);
		}

		//Iterate all skip paths
		foreach($skip_paths as $skip_path)
		{
			if($this->fnmatch($skip_path, $path))
			{
				if(count($reinclude_paths) > 0)
				{
					foreach($reinclude_paths as $reinclude_path)
					{
						if(!$this->fnmatch($reinclude_path, $path))
						{
							//Skippable
							return true;
						}
					}
				}
				else
				{
					//Skippable
					return true;
				}
			}
		}

		//Not skippable
		return false;
	}
}