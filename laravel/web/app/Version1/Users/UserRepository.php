<?php namespace Version1\Users;

Class UserRepository
{
    public function generateAccessKey()
    {
        return strtoupper(substr(sha1(time().str_random(25)), 0, 15));
    }

    // access key also acts as a salt

    public function generatePassword($accessKey)
    {
        $plain = str_random(8);

        $encrypted = \Hash::make($accessKey.$plain);

        return [ 'plain' => $plain, 'encrypted' => $encrypted ];
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

    public function addUser(array $input)
    {
        $input['access_key'] = self::generateAccessKey();

        $password = self::generatePassword($input['access_key']);

        $input['password'] = $password['encrypted'];

        $user = new User($input);

        return $user;
    }
}