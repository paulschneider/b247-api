<?php

namespace Version1\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends \Eloquent implements UserInterface, RemindableInterface {

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
	protected $hidden = array('password', 'age_group_id', 'originating_ip', 'last_login', 'last_login_ip', 'is_active', 'is_deleted', 'created_at', 'updated_at');

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
		return str_random(25);
	}

	public static function getUserChannels($accessKey)
	{
		try
		{
			$data = static::with('profile', 'channels.subChannel.category')->whereAccessKey($accessKey)->firstOrFail()->toArray();

			$channels = $data['channels'];

			unset($data['channels']);

			$user = new \stdClass();

			$user->details = $data;

			$user->channels = clean($channels);

			return $user;
		}
		catch(ModelNotFoundException $e)
		{
			return false;
		}

	}

}
