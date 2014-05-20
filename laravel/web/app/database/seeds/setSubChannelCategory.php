<?php

class setSubChannelCategory extends seeder
{
    public function run()
    {
        \Version1\Models\ChannelCategory::create([
            'channel_id' => 18
            ,'category_id' => 1
        ]);

        \Version1\Models\ChannelCategory::create([
            'channel_id' => 18
            ,'category_id' => 2
        ]);

        \Version1\Models\ChannelCategory::create([
            'channel_id' => 18
            ,'category_id' => 3
        ]);

        \Version1\Models\ChannelCategory::create([
            'channel_id' => 18
            ,'category_id' => 4
        ]);

        $this->command->info('Categories added');
    }
}
