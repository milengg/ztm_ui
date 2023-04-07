<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSetting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'client_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'server_name',
        'server_ip',
        'client_ip',
		'ztmUI',
		'zoneID',
		'zontromat',
        'server_key'
    ];

    /**
	 * Get current ip address
	 *
	 * @return string
	 */
	public function getIpAddress()
	{
        if(empty($this->client_ip))
        {
            if(PHP_OS == 'WINNT')
		    {
		    	return $this->client_ip = '127.0.0.1';
		    } else {
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
		    			if($ip !== '127.0.0.1')
                        {
                            return $this->client_ip = $ip;
                        }
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
		    			    if($ip !== '127.0.0.1')
                            {
                                return $this->client_ip = $ip;
                            }
		    			}
		    		}
		    	}
		    }
        }
	}
}
