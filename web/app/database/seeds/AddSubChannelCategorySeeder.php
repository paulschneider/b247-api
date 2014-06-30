<?php

class AddSubChannelCategorySeeder extends seeder
{
    public function run()
    {
        $categories = DB::table('category')->lists('id');
        $channels = DB::table('channel')->where('parent_channel', '!=', 'null')->lists('id');

        $totalCategories = count($categories)-1;
        $totalChannels = count($channels)-1;

        for($i=0; $i < $totalChannels; $i++) {

            \Version1\Models\ChannelCategory::create([
                'channel_id' => $channels[rand(0, $totalChannels)]
                ,'category_id' => $categories[rand(0, $totalCategories)]
            ]);
        }

        $this->command->info('Categories added to channels');
    }
}
