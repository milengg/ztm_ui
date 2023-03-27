<?php

namespace App\Http\Controllers\API;

use App\Update\Application;
use App\Database\Otf;
use Illuminate\Http\Request;

/**
 * Api controller
 */
class ApiController extends BaseController
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
			$distributable_settings = ['rotators-card-enabled', 'disable-mobileapi'];
			
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
				$place->local_ip = $params['ip'];
			}

			//Set public ip address information
			$place->public_ip = $request->ip();

			//Set place pinged at time
			$place->pinged_at = parse_date('now');
			//Save place
			$place->save();
			
			//Check for settings distribution
			if($place->distribute_settings)
			{
				//Set distribution array
				$distribution = [];
				//Iterate distributable settings
				foreach($distributable_settings as $setting)
				{
					$distribution[$setting] = $place->getSetting($setting);
				}
				//Remove settings distribution
				$place->distribute_settings = 0;
				//Save place
				$place->save();
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
	 * Download current website files
	 *
	 * @return string
	 */
	public function downloadFiles(Request $request)
	{
		return $this->proxyRemote($request, function()
		{
			//Create new releaser
			$releaser = Application::releaser();
			//Get release
			$release = $releaser->getRelease();
			//Check for release
			if(!is_null($release))
			{
				//Return zip file contents
				return $release;
			}
			//No response
			return null;
		});
	}

	/**
	 * Synchronize place
	 *
	 * @param Request $request Request
	 *
	 * @return string|null
	 */
	public function syncPlace(Request $request)
	{
		//Get sync name
		$sync = $request->input('sync');
		//Check for valid sync & data
		if($sync && $request->hasFile('data'))
		{
			//Get file data
			$file = $request->file('data')->path();
			//Read file data
			$data = file_get_contents($file);
			//Check for data
			if(strlen($data) > 0)
			{
				//Get all places
				$places = Place::all();
				//Iterate all places
				foreach($places as $place)
				{
					//Get current place private key
					$priv_key = $place->private_key;
					//Check for private key
					if(empty($priv_key)) continue;
					//Set decrypted sync
					$sync_decrypted = null;
					//Try to deccompress data
					if(openssl_private_decrypt($sync, $sync_decrypted, $priv_key))
					{
						//Check if place is valid
						if($sync_decrypted != 'gourmet') continue;
						//Check for place
						if($place instanceof Place)
						{
							//Set decoded
							$decoded = null;
							//Try to decode data
							if(ssl_decrypt($data, $decoded, $priv_key, 'private'))
							{
								//Try to unzip data
								$uncompressed = gzdecode($decoded);
								//Check for uncompressed data
								if($uncompressed !== false && strlen($uncompressed) > 0)
								{
									//Set uncompressed data
									file_put_contents($file, $uncompressed);
								}
								//Unset data & uncompressed
								unset($data, $decoded, $uncompressed);
								//Set otf based on place
								$otf = new Otf(['database' => $place->database]);
								//Get SQL Statements
								$statements = $this->getSqlStatements($file);
								//Set otf connection
								$connection = $otf->getConnection();
								//Get PDO
								$pdo = $connection->getPdo();
								//Set UTC timezone for import
								$pdo->exec('SET time_zone = "+00:00"');
								//Disable forign checks
								$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
								//Iterate statements
								foreach($statements as $statement)
								{
									//Skip sessions & occupied tables drops & recreates
									if($this->isSqlDropOrCreate($statement, 'occupied') || $this->isSqlDropOrCreate($statement, 'sessions') || $this->isSqlDropOrCreate($statement, 'activitylog') || $this->isSqlDropOrCreate($statement, 'ingredients-store'))
									{
										continue;
									}
									//Change sessions & occupied inserts to replaces
									if($this->isSqlInsert($statement, 'occupied') || $this->isSqlInsert($statement, 'sessions') || $this->isSqlInsert($statement, 'activitylog') || $this->isSqlInsert($statement, 'ingredients-store'))
									{
										$statement = substr_replace($statement, 'REPLACE INTO', 0, 11);
									}
									//Execute statement
									$pdo->exec($statement);
								}
								//Enable forign checks
								$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
								//Set updated time
								$place->updated_at = parse_date('now');
								//Save place
								$place->save();
								//Disconnect connection
								$connection->disconnect();
								//Set ok crypted
								$ok_crypted = null;
								//Encrypt ok result
								if(openssl_private_encrypt('ok', $ok_crypted, $priv_key))
								{
									//Check for valid system email
									if(is_valid_email(setting('system-email')))
									{
										try
										{
											Mail::send('emails.acc-sync', ['place' => $place], function ($m) use ($place)
											{
												$m->to(setting('system-email'))->subject(trans('emails.acc-sync-title', ['name' => def($place->name)]));
											});
										}
										catch(\Exception $ex) { }
									}
									//Return crypted result
									return $ok_crypted;
								}
								//Break cycle
								break;
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Is service alive
	 *
	 * @return string
	 */
	public function isAlive()
	{
		return 'ok';
	}

	/**
	 * Check for sql insert for given table
	 *
	 * @param string $sql   SQL Statement
	 * @param string $table Table name
	 *
	 * @return bool
	 */
	protected function isSqlInsert($sql, $table)
	{
		return $this->isSqlStatement($sql, $table, ['INSERT INTO']);
	}

	/**
	 * Check for sql drop or create for given table
	 *
	 * @param string $sql   SQL Statement
	 * @param string $table Table name
	 *
	 * @return bool
	 */
	protected function isSqlDropOrCreate($sql, $table)
	{
		return $this->isSqlStatement($sql, $table, ['CREATE TABLE', 'DROP TABLE', 'DROP TABLE IF EXISTS']);
	}

	/**
	 * Is SQL statement
	 *
	 * @param string $sql        SQL Statement
	 * @param string $table      Table name
	 * @param array  $statements Statements
	 *
	 * @return bool
	 */
	protected function isSqlStatement($sql, $table, array $statements)
	{
		//Quotes symbols
		$quoutes = ['`','\'','"'];
		//Check for statement for table
		foreach($statements as $statement)
		{
			foreach($quoutes as $quoute)
			{
				if(stripos($sql, $statement . ' ' . $quoute . $table . $quoute) === 0) return true;
			}
		}
		//Not find drop or create for table
		return false;
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
	protected function readRemoteData(Request $request, Place &$place = null)
	{
		//Data array
		$data = [];
		//Get sync name
		$sync = $request->input('sync');
		//Check sync
		if($sync)
		{
			//Get all places
			$places = Place::all();
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
					if($sync_decrypted != 'gourmet') continue;
					//Check for place
					if($c_place instanceof Place)
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

	/**
	 * Update cash register
	 *
	 * @param string $url_address  Url Address
	 * @param int    $printer_type Printer type
	 * @param int    $status       Status
	 *
	 * @return int|null
	 */
	protected function updateCashRegister($url_address, $printer_type, $status)
	{
		//Get all cash registers
		$cash_registers = CashRegister::all();
		//Iterate all cash registers
		foreach($cash_registers as $cash_register)
		{
			if($cash_register->url_address == $url_address && $cash_register->fiscal == $printer_type)
			{
				//Set status
				$cash_register->status = $status;
				//Save cash register
				$cash_register->save();
				//Return cash register id
				return $cash_register->id;
			}
		}
		//Return null
		return null;
	}

	/**
	 * Get SQL Statements
	 *
	 * @param string $file path to sql file
	 *
	 * @return string[]
	 */
	protected function getSqlStatements($file)
	{
		$delimiter = ';';
		$file = fopen($file, 'r');
		$isFirstRow = true;
		$isMultiLineComment = false;
		$statements = [];
		$sql = '';

		while (!feof($file))
		{
			$row = fgets($file);

			//remove BOM for utf-8 encoded file
			if ($isFirstRow)
			{
				$row = preg_replace('/^\x{EF}\x{BB}\x{BF}/', '', $row);
				$isFirstRow = false;
			}

			//1. ignore empty string and comment row
			if (trim($row) == '' || preg_match('/^\s*(#|--\s)/sUi', $row))
			{
				continue;
			}

			//2. Ignore special lines
			if(strpos(trim($row), '/*') === 0 && strpos(trim($row), '*/;') === strlen(trim($row)) - 3)
			{
				continue;
			}

			//3. clear comments
			$row = trim($this->clearSQL($row, $isMultiLineComment));

			//4. parse delimiter row
			if (preg_match('/^DELIMITER\s+[^ ]+/sUi', $row))
			{
				$delimiter = preg_replace('/^DELIMITER\s+([^ ]+)$/sUi', '$1', $row);
				continue;
			}

			//5. separate sql queries by delimiter
			$offset = 0;

			while (strpos($row, $delimiter, $offset) !== false)
			{
				$delimiterOffset = strpos($row, $delimiter, $offset);

				if ($this->isQuoted($delimiterOffset, $row))
				{
					$offset = $delimiterOffset + strlen($delimiter);
				}
				else
				{
					$sql = trim($sql . ' ' . trim(substr($row, 0, $delimiterOffset)));

					//Check for transaction
					if(!(strpos($sql, 'START TRANSACTION') === 0 || strpos($sql, 'END TRANSACTION') === 0))
					{
						$statements[] = $sql;
					}

					$row = substr($row, $delimiterOffset + strlen($delimiter));
					$offset = 0;
					$sql = '';
				}
			}

			$sql = trim($sql . ' ' . $row);
		}

		if (strlen($sql) > 0)
		{
			//Check for transaction
			if(!(strpos($sql, 'START TRANSACTION') === 0 || strpos($sql, 'END TRANSACTION') === 0))
			{
				$statements[] = $row;
			}
		}

		fclose($file);
		return $statements;
	}

	/**
	 * Check if "offset" position is quoted
	 *
	 * @param int    $offset Offset
	 * @param string $text   Text
	 *
	 * @return bool
	 */
	protected function isQuoted($offset, $text)
	{
		if ($offset > strlen($text))
		{
			$offset = strlen($text);
		}

		$isQuoted = false;
		
		for ($i = 0; $i < $offset; $i++)
		{
			if ($text[$i] == "'")
			{
				$isQuoted = !$isQuoted;
			}

			if ($text[$i] == "\\" && $isQuoted)
			{
				$i++;
			}
		}

		return $isQuoted;
	}

	/**
	 * Remove comments from sql
	 *
	 * @param string $sql            SQL
	 * @param bool   $isMultiComment Is Multi Comment?
	 *
	 * @return string
	 */
	protected function clearSQL($sql, &$isMultiComment)
	{
		if ($isMultiComment)
		{
			if (preg_match('#\*/#sUi', $sql))
			{
				$sql = preg_replace('#^.*\*/\s*#sUi', '', $sql);
				$isMultiComment = false;
			}
			else
			{
				$sql = '';
			}

			if(trim($sql) == '')
			{
				return $sql;
			}
		}

		$offset = 0;

		while (preg_match('{--\s|#|/\*[^!]}sUi', $sql, $matched, PREG_OFFSET_CAPTURE, $offset))
		{
			list($comment, $foundOn) = $matched[0];

			if ($this->isQuoted($foundOn, $sql))
			{
				$offset = $foundOn + strlen($comment);
			}
			else
			{
				if (substr($comment, 0, 2) == '/*')
				{
					$closedOn = strpos($sql, '*/', $foundOn);

					if ($closedOn !== false)
					{
						$sql = substr($sql, 0, $foundOn) . substr($sql, $closedOn + 2);
					}
					else
					{
						$sql = substr($sql, 0, $foundOn);
						$isMultiComment = true;
					}
				}
				else
				{
					$sql = substr($sql, 0, $foundOn);
					break;
				}
			}
		}

		return $sql;
	}
}