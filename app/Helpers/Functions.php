<?php

/**
 * SSL encrypt
 *
 * @param string $source Source data
 * @param string $type   Type: private, public
 * @param string $key    Key
 *
 * @return bool
 */
function ssl_encrypt($source, &$output, $key, $type)
{
	//Assumes 2048 bit key and encrypts in chunks.
	$ok = false;
	$maxlength = 245;
	$output = '';

	while($source)
	{
		$input = substr($source, 0, $maxlength);
		$source = substr($source, $maxlength);

		if($type == 'private')
		{
			$ok = openssl_private_encrypt($input, $encrypted, $key);
		}
		else
		{
			$ok = openssl_public_encrypt($input, $encrypted, $key);
		}
		
		if(!$ok) return false;
		$output .= $encrypted;
	}

	return $ok;
}

/**
 * SSL decrypt
 *
 * @param string $source Source data
 * @param string $type   Type: private, public
 * @param string $key    Key
 *
 * @return bool
 */
function ssl_decrypt($source, &$output, $key, $type)
{
	//The raw PHP decryption functions appear to work
	//on 256 Byte chunks. So this decrypts long text
	//encrypted with ssl_encrypt().
	$ok = false;
	$maxlength = 256;
	$output = '';
	
	while($source)
	{
		$input = substr($source, 0, $maxlength);
		$source = substr($source, $maxlength);
		
		if($type=='private')
		{
			$ok = openssl_private_decrypt($input, $out, $key);
		}
		else
		{
			$ok = openssl_public_decrypt($input, $out, $key);
		}
       
		if(!$ok) return false;
		$output .= $out;
	}
	
	return $ok;
}

/**
 * Unparse url
 *
 * @param array $parsed_url Parsed url
 *
 * @return string
 */
function unparse_url($parsed_url)
{
	$scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
	$host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
	$port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
	$user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
	$pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
	$pass     = ($user || $pass) ? "$pass@" : '';
	$path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
	$query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
	$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
	return "$scheme$user$pass$host$port$path$query$fragment";
}

/**
 * Parse date
 *
 * @param mixed  		$value		String for parse
 * @param string|array	$format		Format or array with formats
 * @param bool			$timestamp	Linux Timestamp instead of object?
 *
 * @return DateTime|int
 */
function parse_date($value, $format = null, $timestamp = false)
{
	//Get timezone
	$timezone = date_default_timezone_get();
	//Get date time zone
	$date_timezone = new DateTimeZone($timezone);

    //Check for now
    if(is_string($value) && $value == 'now')
    {
        return new Carbon\Carbon('now', $date_timezone);
    }

	//Check for number
    if(val_check($value))
    {
        return Carbon\Carbon::createFromTimestamp(intval($value));
    }

    //Check for format
    if($format !== null)
    {
        //Remove date elements
        $mask = preg_replace('/[dDjlNSwzWFmMntLoYyaABgGhHisueIOPTZcrU]+/', '', $format);
        //Check for valid mask
        if(strlen($mask) > 0)
        {
            //Get delimiter
            $delimiter = $mask[0];
            //Get components
            $v_components = explode($delimiter, $value);
            $f_components = explode($delimiter, $format);
            //Check components count
            if(count($v_components) < count($f_components))
            {
                //Create new date
                $now = new Carbon\Carbon('now', $date_timezone);
                //Add missing components
                for($i = count($v_components); $i < count($f_components); $i++)
                {
                    $value .= $delimiter . $now->format($f_components[$i]);
                }
            }
        }
    }

    //Check if possible to represend date from value
    if (!is_string($value) && !is_array($value) && !is_int($value) && !($value instanceof DateTime))
    {
        return null;
    }

    //Check for DateTime instance
    if ($value instanceof DateTime)
    {
        return ($timestamp) ? $value->getTimestamp() : $value;
    }

    //Get value as string
    $value = (string)$value;

    //Remove quotes
    if (($length = strlen($value)) > 1 && "'" === $value[0] && "'" === $value[$length-1])
    {
        $value = substr($value, 1, -1);
    }

    //Check for formats
    if($format === null)
    {
        //Date formats
        $date_formats = array
        (
            'D, d M Y H:i:s T',
            'D, d-M-y H:i:s T',
            'D, d-M-Y H:i:s T',
            'D, d-m-y H:i:s T',
            'D, d-m-Y H:i:s T',
            'D M j G:i:s Y',
            'D M d H:i:s Y T',
        );

        //Check internal formats
        foreach ($date_formats as $date_format)
        {
			try
			{
				if (false !== $date = Carbon\Carbon::createFromFormat($date_format, $value, $date_timezone))
				{
					return ($timestamp) ? $date->getTimestamp() : $date;
				}
			}
			catch (Exception $ex) { }
        }

        //Last chance to parse date
        if (false !== $date = new Carbon\Carbon($value, $date_timezone))
        {
            return ($timestamp) ? $date->getTimestamp() : $date;
        }
    }
    else
    {
        //Check for formats array
        if(is_array($format))
        {
            //Create
            $format = flatten($format);
            //Iterate all formats
            foreach ($format as $date_format)
            {
				try
				{
					if (false !== $date = Carbon\Carbon::createFromFormat($date_format, $value, $date_timezone))
					{
						return ($timestamp) ? $date->getTimestamp() : $date;
					}
				}
				catch (Exception $ex) { }
            }
        }
        else
        {
            //Parse from ane format
			try
			{
				if (false !== $date = Carbon\Carbon::createFromFormat((string)$format, $value, $date_timezone))
				{
					return ($timestamp) ? $date->getTimestamp() : $date;
				}
			}
			catch (Exception $ex) { }
        }
    }

    //Return error
    return null;
}