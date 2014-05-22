<?php

class AddArticlesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i < 30; $i++) {

            $title = $faker->sentence( rand(3,9) );

            \Version1\Models\Article::create([
                'content_type' => 4
                ,'title' => $title
                ,'sef_name' => safeName($title)
                ,'sub_heading' => $faker->sentence( rand(3,9) )
                ,'body' => $faker->paragraph( rand(3,9) )
                ,'postcode' => $faker->postcode()
                ,'is_picked' => $faker->randomNumber(false, true)
            ]);
        }

        $this->command->info('Articles Created');
    }

}
