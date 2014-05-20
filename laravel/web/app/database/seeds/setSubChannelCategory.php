<?php

class setSubChannelCategory extends seeder
{
    public function run()
    {
        ChannelCategory::create([
            'channel_id' => 18
            ,'category_id' => 1
        ]);

        ChannelCategory::create([
            'channel_id' => 18
            ,'category_id' => 2
        ]);

        ChannelCategory::create([
            'channel_id' => 18
            ,'category_id' => 3
        ]);

        ChannelCategory::create([
            'channel_id' => 18
            ,'category_id' => 4
        ]);

        $this->command->info('Categories added');
    }
}
