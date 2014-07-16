<?php namespace Version1\Users;

Class UserRepository
{
    public function generateAccessKey()
    {
        return strtoupper(substr(sha1(time().str_random(25)), 0, 15));
    }

    // access key also acts as a salt

    public function generatePassword()
    {
        $plain = str_random(8);

        $encrypted = $this->makeHash($plain);

        return [ 'plain' => $plain, 'encrypted' => $encrypted ];
    }

    public function makeHash($password)
    {
        return \Hash::make($password);
    }

    public function getUserChannels($accessKey)
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

    public function create(array $input)
    {
        $input['access_key'] = self::generateAccessKey();

        $password = self::generatePassword();

        $user = new User($input);

        $user->first_name = $input['firstname'];
        $user->last_name = $input['lastname'];
        $user->password = $password['encrypted'];        

        $user->save();

        $user->plain_pass = $password['plain'];

        return $user;
    }

    public function getUserInactiveChannels( $userId )
    {
        $result = UserInactiveChannel::select('channel_id AS id')->where('user_id', $userId)->get();

        $hidden = [];

        $hidden[] = $result->map(function( $channel ){
             return (int) $channel->id;
        });

        return $hidden[0]->toArray();
    }

    public function authenticate($email)
    {
        return User::select('id', 'first_name', 'last_name', 'email', 'password', 'access_key')->where('email', $email)->first();
    }
}
