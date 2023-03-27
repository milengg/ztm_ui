<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_name',
        'version',
        'ip',
        'public_key',
        'private_key',
        'distribute_settings',
        'pinged_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'distribute_settings' => 'boolean',
    ];

    /**
	 * On model boot
	 *
	 * @return void
	 */
	public static function boot()
    {
		parent::boot();

		//On creating new place
		self::creating(function($model)
		{
            $model->generateKeys();
        });

		//On updating place
		self::updating(function($model)
		{
            $model->generateKeys();
        });
	}

    /**
	 * Get is place is live (online)
	 *
	 * @return bool
	 */
	public function getIsLiveAttribute()
	{
		if(!is_null($this->pinged_at))
		{
			return (parse_date('now')->diffInSeconds($this->pinged_at) < 3600);
		}

		return false;
	}

    /**
	 * Generate place keys
	 *
	 * @return void
	 */
	protected function generateKeys()
	{
		//Configuration
		$config = array
		(
			'digest_alg' => 'sha256',
			'private_key_bits' => 2048,
			'private_key_type' => OPENSSL_KEYTYPE_RSA,
		);

		//Check for missing keys
		if(empty($this->private_key) || empty($this->public_key))
		{
			//Set variables
			$pub_key = null;
			$priv_key = null;
			//Create the private and public key
			$res = openssl_pkey_new($config);
			//Extract the private key from $res to $priv_key
			openssl_pkey_export($res, $priv_key);
			//Extract the public key from $res to $pubKey
			$pub_key = openssl_pkey_get_details($res);
			$pub_key = $pub_key['key'];
			//Set keys to model
			$this->private_key = $priv_key;
			$this->public_key = $pub_key;
		}
	}
}
