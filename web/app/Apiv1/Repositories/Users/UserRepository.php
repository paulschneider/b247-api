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

    /**
     * retrieve user account and profile via email
     * 
     * @param  string $email [user account email address]
     * @return Apiv1\Repositories\Users\User
     */
    public function authenticate($email)
    {
        $result = User::select('id', 'first_name', 'last_name', 'email', 'password', 'access_key')->with('profile', 'inactiveChannels', 'inactiveCategories', 'districts')->where('email', $email)->get();

        # if we didn't get anything go back
        if( $result->isEmpty() ) {
            return;
        }

        return self::processProfile($result->first());
    }

    /**
     * retrieve the user profile using a provided accessKey
     * 
     * @param  string $accessKey [unique identifier for the user account]
     * @return Apiv1\Repositories\Users\User
     */
    public function getProfile($accessKey)
    {
        $result = User::with('profile', 'inactiveChannels', 'inactiveCategories', 'districts', 'broadcasts')->where('access_key', $accessKey)->get();

        # if we didn't get anything go back
        if( $result->isEmpty() ) {
            return;
        }

        return self::processProfile($result->first());
    }

    /**
     * to be able to check what the preferences are later on we'll create simple arrays for each preference
     * type. 
     * @param  User $user
     * @return user $user
     */
    private function processProfile($user)
    {
        # otherwise format the inactive content into something more usable
        $channels = [];
        $categories = [];
        $districts = [];
        $broadcasts = [];

        foreach($user->inactive_channels AS $inactive)
        {
            $channels[] = $inactive['channel_id'];
        }    

        # set the results back against the user
        unset($user->inactive_channels);
        $user->inactive_channels = $channels;

        foreach($user->inactive_categories AS $inactive)
        {
            $categories[$inactive['category_id']] = [
                'subchannel' => $inactive['sub_channel_id'],
                'category' => $inactive['category_id'],
            ];
        }

        # set the results back against the user
        unset($user->inactive_categories);
        $user->inactive_categories = $categories;        

        foreach($user->districts AS $district)
        {
            $districts[] = $district->district_id;
        }

        # set the results back against the user
        unset($user->districts);
        $user->districts = $districts;

        # these are the communication preferences for the user. If they are opted to receive various communications
        # they go into this list
        foreach($user->broadcasts AS $broadcast)
        {
            $broadcasts[] = $broadcast->communication_id;
        }

        # set the results back against the user
        unset($user->broadcasts);
        $user->broadcasts = $broadcasts;
        
        return $user;
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

    public function getUserProfile($user)
    {
        return UserProfile::where('user_id', $user->id)->first();
    }

    /**
     * store or update a user account profile
     * 
     * @param  Apiv1\Repositories\Users\User $user
     * @param  array $form [description]
     * @return boolean
     */
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

    /**
     * associate a list of channel and category preferences to a user account
     * 
     * @param Apiv1\Repositories\Users\User $user
     * @param array $data [array of categories and channels to "deactivate"]
     */
    public function setContentPreferences($user, $data)
    {
        # remove all previous user prefs for this user
        DB::table('user_inactive_channel')->where('user_id', $user->id)->delete();

        # insert the new prefs, if there are any
        if(!empty($data->channels)) {
            DB::table('user_inactive_channel')->insert($data->channels);
        }           
            
        # remove all previous user prefs for the category being affected for a specified sub_channel
        DB::table('user_inactive_category')->where('user_id', $user->id)->delete();   

        # if there are category prefs then insert them too
        if( count($data->categories) > 0 ) {                     
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

    public function setBroadcastPreferences($user, $broadcasts)
    {
        # shortcut the table as we'll reference it a couple of times and it has a long name
        $table = 'user_comms_preference';

        # remove all previous user prefs for this user
        DB::table($table)->where('user_id', $user->id)->delete();    

        # insert the new prefs, if there are any
        if(!empty($broadcasts)) {
            DB::table($table)->insert($broadcasts);
        } 
    }
}