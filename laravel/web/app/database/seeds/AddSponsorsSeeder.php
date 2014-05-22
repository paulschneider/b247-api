<?php

class AddSponsorsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i < 30; $i++) {

            $title = $faker->sentence( rand(3,9) );

            \Version1\Models\Sponsor::create([
                'image_id' => 1
                ,'title' => $faker->sentence( rand(3,6) )
                ,'url' => $faker->url()
                ,'display_start' => $from = $faker->dateTimeBetween('+1 days', '+2 months')->format('Y:m:d')
                ,'display_end' => $faker->dateTimeBetween('+2 months',  '+8 months')->format('Y:m:d')
            ]);
        }

        $this->command->info('Sponsors Created');
    }

}
