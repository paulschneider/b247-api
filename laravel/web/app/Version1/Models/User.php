<?php

namespace Version1\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends BaseModel implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [

		'password', 'originating_ip', 'last_login', 'last_login_ip', 'is_active', 'is_deleted', 'created_at', 'updated_at'

	];

	/**
	* The attributes of a user that can be manually set
	*
	* @var array
	*/
	protected $fillable = [

		'access_key', 'first_name', 'last_name', 'email', 'password'

	];

	/**
	* Form validation rules for a new user
	*
	* @var array
	*/
	protected static $rules = [

		'first_name' => 'required'
		,'last_name' => 'required'
		,'email' => 'required'

	];

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	* Relate the user to a profile record
	*
	* @return ???
	*/
	public function profile()
	{
		return $this->hasOne('\Version1\Models\UserProfile');
	}

	public function Channels()
	{
		return $this->belongsToMany('\Version1\Models\Channel', 'user_channel');
	}

	public static function generateAccessKey()
	{
		return strtoupper(substr(sha1(time().str_random(25)), 0, 15));
	}

	// access key also acts as a salt

	public static function generatePassword($accessKey)
	{
		$plain = str_random(8);

		$encrypted = \Hash::make($accessKey.$plain);

		return [ 'plain' => $plain, 'encrypted' => $encrypted ];
	}

	public static function getUserChannels($accessKey)
	{
		try
		{
			return static::with('profile', 'channels.subChannel.category')->whereAccessKey($accessKey)->firstOrFail()->toArray();
		}
		catch(ModelNotFoundException $e)
		{
			return false;
		}
	}

	public static function addUser(array $input)
	{
		$input['access_key'] = static::generateAccessKey();

		$password = static::generatePassword($input['access_key']);

		$input['password'] = $password['encrypted'];

		$user = new User($input);

		return $user;
	}
}
