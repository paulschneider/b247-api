<?php

class addChannels extends Seeder
{
    public function run()
    {
        Channel::truncate();

        Channel::create([
            'content_type' => 1
            ,'icon_img_id' => null
            ,'name' => 'News'
            ,'sef_name' => 'news'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        Channel::create([
            'content_type' => 1
            ,'icon_img_id' => null
            ,'name' => 'What\'s On'
            ,'sef_name' => 'whats-on'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);
    }

}
