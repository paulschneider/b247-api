<?php

class addContentTypes extends Seeder
{
    public function run()
    {
        DB::table('content_type')->delete();

        $statement = "ALTER TABLE content_type AUTO_INCREMENT = 1;";

        DB::unprepared($statement);

        ContentType::create([
            'type' => 'Channel'
            ,'created_at' => new DateTime
        ]);

        ContentType::create([
            'type' => 'Sub-Channel'
            ,'created_at' => new DateTime
        ]);

        ContentType::create([
            'type' => 'Category'
            ,'created_at' => new DateTime
        ]);

        ContentType::create([
            'type' => 'Article'
            ,'created_at' => new DateTime
        ]);

        $this->command->info('Content Types Added');
    }

}
