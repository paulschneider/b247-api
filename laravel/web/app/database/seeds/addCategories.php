<?php

class addCategories extends Seeder
{
    public function run()
    {
        // id = 1
        Category::create([
            'content_type' => 3
            ,'icon_img_id' => null
            ,'name' => 'Reviews'
            ,'sef_name' => 'reviews'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 2
        Category::create([
            'content_type' => 3
            ,'icon_img_id' => null
            ,'name' => 'Interviews'
            ,'sef_name' => 'interviews'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 3
        Category::create([
            'content_type' => 3
            ,'icon_img_id' => null
            ,'name' => 'Features'
            ,'sef_name' => 'features'
            ,'colour' => '#0000ff'
            ,'created_at' => new DateTime
        ]);

        // id = 4
        Category::create([
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
