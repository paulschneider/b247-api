<?php

class addChannels extends Seeder
{
    public function run()
    {
        // id = 1
        \Version1\Models\Channel::create([
            'content_type' => 1
            ,'icon_img_id' => null
            ,'name' => 'News'
            ,'sef_name' => 'news'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 2
        \Version1\Models\Channel::create([
            'content_type' => 1
            ,'icon_img_id' => null
            ,'name' => 'What\'s On'
            ,'sef_name' => 'whats-on'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 3
        \Version1\Models\Channel::create([
            'content_type' => 1
            ,'icon_img_id' => null
            ,'name' => 'Comments'
            ,'sef_name' => 'comment'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 4
        \Version1\Models\Channel::create([
            'content_type' => 1
            ,'icon_img_id' => null
            ,'name' => 'Food and Drink'
            ,'sef_name' => 'food-and-drink'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 5
        \Version1\Models\Channel::create([
            'content_type' => 1
            ,'icon_img_id' => null
            ,'name' => 'Motoring'
            ,'sef_name' => 'motoring'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        ############################################## Sub-Channels of News

        // id = 6
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 1
            ,'icon_img_id' => null
            ,'name' => 'Arts'
            ,'sef_name' => 'arts'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 7
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 1
            ,'icon_img_id' => null
            ,'name' => 'Crime'
            ,'sef_name' => 'crime'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 8
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 1
            ,'icon_img_id' => null
            ,'name' => 'Education'
            ,'sef_name' => 'education'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 9
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 1
            ,'icon_img_id' => null
            ,'name' => 'Environment'
            ,'sef_name' => 'environment'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 10
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 1
            ,'icon_img_id' => null
            ,'name' => 'Health'
            ,'sef_name' => 'health'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 11
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 1
            ,'icon_img_id' => null
            ,'name' => 'Media'
            ,'sef_name' => 'media'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 12
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 1
            ,'icon_img_id' => null
            ,'name' => 'Politics'
            ,'sef_name' => 'politics'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 13
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 1
            ,'icon_img_id' => null
            ,'name' => 'Society'
            ,'sef_name' => 'society'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 14
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 1
            ,'icon_img_id' => null
            ,'name' => 'Sport'
            ,'sef_name' => 'sport'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 15
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 1
            ,'icon_img_id' => null
            ,'name' => 'Transport'
            ,'sef_name' => 'transport'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 16
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 1
            ,'icon_img_id' => null
            ,'name' => 'Newswire'
            ,'sef_name' => 'newswire'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        ############################################## Sub-Channels of What's On

        // id = 17
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 2
            ,'icon_img_id' => null
            ,'name' => 'Listings and Events'
            ,'sef_name' => 'listings-and-events'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 18
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 2
            ,'icon_img_id' => null
            ,'name' => 'Music'
            ,'sef_name' => 'music'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 19
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 2
            ,'icon_img_id' => null
            ,'name' => 'Festivals'
            ,'sef_name' => 'festivals'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 20
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 2
            ,'icon_img_id' => null
            ,'name' => 'Theatre'
            ,'sef_name' => 'theatre'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 21
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 2
            ,'icon_img_id' => null
            ,'name' => 'Films'
            ,'sef_name' => 'films'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 22
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 2
            ,'icon_img_id' => null
            ,'name' => 'Comedy'
            ,'sef_name' => 'comedy'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 23
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 2
            ,'icon_img_id' => null
            ,'name' => 'Arts'
            ,'sef_name' => 'arts'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 24
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 2
            ,'icon_img_id' => null
            ,'name' => 'Video'
            ,'sef_name' => 'video'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 25
        \Version1\Models\Channel::create([
            'content_type' => 2
            ,'parent_channel' => 2
            ,'icon_img_id' => null
            ,'name' => 'Venues'
            ,'sef_name' => 'venues'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        $this->command->info('Channels added');
    }
}
