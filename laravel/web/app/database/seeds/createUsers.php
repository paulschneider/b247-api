<?php

class createUsers extends Seeder
{
    public function run()
    {
        \Version1\Models\User::create([
            "access_key" => 'OGuzm6pDHsFwrXW6Zb0ICc1iR'
            ,"first_name" => "Paul"
            ,"last_name" => "Schneider"
            ,"email" => "paul.schneider@yepyep.co.uk"
            ,"password" => Hash::make("password")
        ]);

        \Version1\Models\User::create([
            "access_key" => 'OGuzm6pDHsFwrXW6Zb0ICc1iR1'
            ,"first_name" => "David"
            ,"last_name" => "Woodall"
            ,"email" => "david.woodall@wildfirecomms.co.uk"
            ,"password" => Hash::make("password")
        ]);

        $this->command->info('Users created');
    }

}
