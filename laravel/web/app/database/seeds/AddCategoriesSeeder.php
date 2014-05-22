<?php

class AddCategoriesSeeder extends Seeder
{
    public function run()
    {
        // id = 1
        \Version1\Models\Category::create([
            'content_type' => 3
            ,'icon_img_id' => null
            ,'name' => 'Reviews'
            ,'sef_name' => 'reviews'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 2
        \Version1\Models\Category::create([
            'content_type' => 3
            ,'icon_img_id' => null
            ,'name' => 'Interviews'
            ,'sef_name' => 'interviews'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 3
        \Version1\Models\Category::create([
            'content_type' => 3
            ,'icon_img_id' => null
            ,'name' => 'Features'
            ,'sef_name' => 'features'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 4
        \Version1\Models\Category::create([
            'content_type' => 3
            ,'icon_img_id' => null
            ,'name' => 'Big Jeff'
            ,'sef_name' => 'big-jeff'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        $this->command->info('Categories added');
    }

}
