<?php namespace Version1\Venues;

use Version1\Venues\VenueInterface;
use Version1\Venues\Venue;
use Version1\Models\BaseModel;

Class VenueRepository extends BaseModel implements VenueInterface {

    public function getVenueList()
    {
        return Venue::active()->alive()->lists('name', 'id');
    }

    public function getVenue($venueId)
    {
        return Venue::findOrFail($venueId);
    }

    public function getVenues()
    {
        return Venue::alive()->get();
    }

    public function store($form)
    {
        if( ! empty($form['id']))
        {
            $venue = self::getVenue($form['id']);
        }
        else
        {
            $venue = new Venue();
        }

        $faker = \Faker\Factory::create();

        $venue->name = ! empty($form['name']) ? $form['name'] : $faker->company();
        $venue->sef_name = safename($venue->name);
        $venue->address_line_1 = ! empty($form['address1']) ? $form['address1'] : $faker->streetName();
        $venue->address_line_2 = ! empty($form['address2']) ? $form['address2'] : $faker->streetAddress();
        $venue->address_line_3 = ! empty($form['address3']) ? $form['address3'] : $faker->city();
        $venue->postcode = ! empty($form['postcode']) ? $form['postcode'] : $faker->postcode();
        $venue->email = ! empty($form['email']) ? $form['email'] : $faker->email();
        $venue->phone = ! empty($form['phone']) ? $form['phone'] : $faker->phoneNumber();
        $venue->facebook = ! empty($form['facebook']) ? $form['facebook'] : strtolower(str_replace(' ', '.', $faker->name()));
        $venue->twitter = ! empty($form['twitter']) ? $form['twitter'] : $faker->userName();

        $venue->save();

        return $venue;
    }

}
