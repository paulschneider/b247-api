<?php

class CreateAgeGroupsSeeder extends Seeder
{
    public function run()
    {
        \Version1\Models\AgeGroup::create([
            "range" => "0-9"
        ]);

        \Version1\Models\AgeGroup::create([
            "range" => "10-19"
        ]);

        \Version1\Models\AgeGroup::create([
            "range" => "20-29"
        ]);

        \Version1\Models\AgeGroup::create([
            "range" => "30-39"
        ]);

        \Version1\Models\AgeGroup::create([
            "range" => "40-49"
        ]);

        \Version1\Models\AgeGroup::create([
            "range" => "50-59"
        ]);

        \Version1\Models\AgeGroup::create([
            "range" => "60-69"
        ]);

        \Version1\Models\AgeGroup::create([
            "range" => "69-70"
        ]);

        $this->command->info('Age groups Added');
    }

}
