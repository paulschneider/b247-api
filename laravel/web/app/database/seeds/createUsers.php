<?php

class createUsers extends Seeder
{
    public function run()
    {
        $key = str_random(25);

        $salt = $key;

        \Version1\Models\User::create([
            "age_group_id" => 4
            ,"access_key" => $key
            ,"first_name" => "Paul"
            ,"last_name" => "Schneider"
            ,"nickname" => "schneidey"
            ,"email" => "paul.schneider@yepyep.co.uk"
            ,"password" => Hash::make($salt."password")
        ]);

        \Version1\Models\User::create([
            "age_group_id" => 4
            ,"access_key" => $key
            ,"first_name" => "David"
            ,"last_name" => "Woodall"
            ,"nickname" => "woody"
            ,"email" => "david.woodall@wildfirecomms.co.uk"
            ,"password" => Hash::make($salt."password")
        ]);
    }

}
