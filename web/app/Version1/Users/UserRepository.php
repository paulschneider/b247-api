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

        $user->first_name = $input['firstName'];
        $user->last_name = $input['lastName'];
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
        return User::select('id', 'first_name', 'last_name', 'email', 'password', 'access_key')->with('profile')->where('email', $email)->first();
    }

    public function hashAndStore($email, $password)
    {
        $newAccessKey = $this->generateAccessKey();

        $result =  \DB::table('user')->where('email', $email)->update([ 
            'password' => $this->makeHash($password),
            'access_key' => $newAccessKey
        ]);   

        if( ! $result )
        {
            return false;
        }

        $response = new \stdClass();
        $response->accessKey = $newAccessKey;

        return $response;
    }

    public function generateAndStore($email)
    {
        $password = $this->generatePassword();

        $result = \DB::table('user')->where('email', $email)->update([ 
            'password' => $password['encrypted'],
            'access_key' => $this->generateAccessKey()
        ]);

        if( ! $result)
        {
            return false;
        }
        
        return $password['plain'];
    }

    public function getUserAccessKey($userId)
    {
        return User::select('access_key')->where('id', $userId)->get();
    }

    public function getProfile($accessKey)
    {
        return User::with('profile')->where('access_key', $accessKey)->first();
    }

    public function getUserProfile($user)
    {
        return UserProfile::where('user_id', $user->id)->first();
    }

    public function saveProfile($user, $form)
    {
        if( ! $user->has('profile') )
        {
            $profile = new UserProfile();           
            $profile->user_id = $user->id;
        }
        else
        {
            $profile = $this->getUserProfile($user);               
        }

        $profile->age_group_id = $form['ageGroup'];
        $profile->nickname = $form['nicknameame'];
        $profile->facebook = isset( $form['facebook'] ) ? $form['facebook'] : null;
        $profile->twitter = isset( $form['twitter'] ) ? $form['twitter'] : null;
        $profile->postcode = $form['postcode'];
        $profile->updated_at = getDateTime();

        if(isset($user->lat) && isset($user->lon))
        {
            $profile->lat = $user->lat;
            $profile->lon = $user->lon;
        }

        return $profile->save();
    }
}
