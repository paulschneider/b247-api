<?php namespace Apiv1\Repositories\Users;

use DB;
use Hash;

Class UserRepository
{
    public function generateAccessKey()
    {
        return strtoupper(substr(sha1(time().str_random(25)), 0, 15));
    }

    # access key also acts as a salt

    public function generatePassword()
    {
        $plain = str_random(8);

        $encrypted = $this->makeHash($plain);

        return [ 'plain' => $plain, 'encrypted' => $encrypted ];
    }

    public function makeHash($password)
    {
        return Hash::make($password);
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

    public function authenticate($email)
    {
        return User::select('id', 'first_name', 'last_name', 'email', 'password', 'access_key')->with('profile')->where('email', $email)->first();
    }

    public function hashAndStore($email, $password)
    {
        $newAccessKey = $this->generateAccessKey();

        $result =  DB::table('user')->where('email', $email)->update([ 
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

        $result = DB::table('user')->where('email', $email)->update([ 
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
        $result = User::with('profile', 'inactiveChannels', 'inactiveCategories')->where('access_key', $accessKey)->get();

        # if we didn't get anything go back
        if( $result->isEmpty() ) {
            return;
        }

        // grab the user from the collection
        $user = $result->first();

        # otherwise format the inactive content into something more usable
        $channels = [];
        $categories = [];

        if(is_array($user->inactive_channels) && count($user->inactive_channels) > 0)
        {
            foreach($user->inactive_channels AS $inactive)
            {
                $channels[] = $inactive['channel_id'];
            }    
        }
        
        foreach($user->inactive_categories AS $inactive)
        {
            $categories[$inactive['category_id']] = [
                'subchannel' => $inactive['sub_channel_id'],
                'category' => $inactive['category_id'],
            ];
        }

        # set the results back against the user
        $user->inactive_channels = $channels;
        $user->inactive_categories = $categories;

        return $user;
    }

    public function getUserProfile($user)
    {
        return UserProfile::where('user_id', $user->id)->first();
    }

    public function saveProfile($user, $form)
    {
        if( ! $user->has('profile') || empty($user->profile))
        {
            $profile = new UserProfile();           
            $profile->user_id = $user->id;
        }
        else
        {
            $profile = $this->getUserProfile($user);               
        }

        $profile->age_group_id = $form['ageGroup'];
        $profile->nickname = $form['nickName'];
        $profile->facebook = isset( $form['facebook'] ) ? $form['facebook'] : null;
        $profile->twitter = isset( $form['twitter'] ) ? $form['twitter'] : null;
        $profile->postcode = $form['postCode'];
        $profile->updated_at = getDateTime();

        if(isset($user->lat) && isset($user->lon))
        {
            $profile->lat = $user->lat;
            $profile->lon = $user->lon;
        }

        return $profile->save();
    }

    public function setContentPreferences($user, $data)
    {
        # if there are channels prefs then insert them
        if( count($data->channels) > 0 )
        {            
            foreach( $data->channels AS $channel ) 
            {
                # remove all previous user prefs for the channel being affected
                DB::table('user_inactive_channel')->where('user_id', $user->id)->where('channel_id', $channel['channel_id'])->delete();
            }

            DB::table('user_inactive_channel')->insert($data->channels);
        }
        
        # if there are category prefs then insert them too
        if( count($data->categories) > 0 )
        {
            foreach( $data->categories AS $category )
            {
                # remove all previous user prefs for the category being affected for a specified sub_channel
                DB::table('user_inactive_category')->where('user_id', $user->id)->where('sub_channel_id', $category['sub_channel_id'])->delete();   
            }
            
            DB::table('user_inactive_category')->insert($data->categories);    
        }
        
        return true;
    }

    /**
     * associate a list of district identifiers with a specified user account
     * 
     * @var Apiv1\Repositories\Users\User
     * @var array [a list of district identifier (int)]
     * @return Apiv1\Repositories\Users\User $user
     */
    public function setUserDistrictPreferences($user, $districts)
    {    
        # which table do we want to use for this operation
        $table = 'user_district';

        # check we've been provided the right type before we go on
        if(is_array($districts))
        {   
            $rows = [];

            # create an array of rows that we can insert into the database
            foreach($districts AS $district)
            {
                $rows[] = [
                    'user_id' => $user->id,
                    'district_id' => $district,
                    'created_at' => getDateTime() // helper function
                ];
            }

            # clear out any previous district preferences for this user
            DB::table($table)->where('user_id', $user->id)->delete();

            # if we have some districts to insert, do it
            if(count($rows) > 0) {
                DB::table($table)->insert($rows);    
            }

            # ... and finally assign the districts to the user object which we'll send back to the caller
            $user->districts = $districts;

            return $user;            
        }

        return false;
    }
}
