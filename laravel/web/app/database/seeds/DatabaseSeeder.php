<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// remove any foreign key constraints that prevent us re-adding the test content
		// $this->call('removeConstraints');
		//
		// // add in the content types table ( almost all content requires this pre-exist )
		//$this->call('addContentTypes');
		//
		// // add in a load of test channels
		//$this->call('addChannels');
		//
		// // add in some categories and relate them to their parent channels and sub-channels
		$this->call('addCategories');
		//
		// // add some categories to a sub-channel
		$this->call('setSubChannelCategory');

		// populate the age groups table
		$this->call('createAgeGroups');

		// add some users to the user table
		$this->call('createUsers');
	}

}
