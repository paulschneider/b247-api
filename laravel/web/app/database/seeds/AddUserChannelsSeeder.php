<?php

class AddUserChannelsSeeder extends Seeder
{
    public function run()
    {
        \Version1\Models\UserChannel::create([
            "user_id" => 1
            ,"channel_id" => 1
            ,'notify' => true
        ]);

        \Version1\Models\UserChannel::create([
            "user_id" => 1
            ,"channel_id" => 2
            ,'notify' => true
        ]);

        \Version1\Models\UserChannel::create([
            "user_id" => 1
            ,"channel_id" => 3
            ,'notify' => true
        ]);

        \Version1\Models\UserChannel::create([
            "user_id" => 1
            ,"channel_id" => 4
            ,'notify' => true
        ]);

        $this->command->info('Channels added to users');
    }
}
