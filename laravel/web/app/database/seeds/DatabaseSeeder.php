<?php

class DatabaseSeeder extends Seeder {

	private $tables = [
		'age_group'
		,'article'
		,'article_category'
		,'article_image'
		,'asset'
		,'category'
		,'channel'
		,'channel_category'
		,'content_type'
		,'event'
		,'keyword'
		,'keyword_applied'
		,'search'
		,'sponsor'
		,'user'
		,'user_article'
		,'user_category'
		,'user_channel'
		,'user_profile'
		,'venue'
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		#$this->cleanDatabase();

		// add in the content types table ( almost all content requires this pre-exist )
		#$this->call('AddContentTypesSeeder');

		// add in a load of test channels
		#$this->call('AddChannelsSeeder');

		// add in some categories and relate them to their parent channels and sub-channels
		#$this->call('AddCategoriesSeeder');

		// add some categories to a sub-channel
		#$this->call('AddSubChannelCategorySeeder');

		// populate the age groups table
		#$this->call('CreateAgeGroupsSeeder');

		// add some users to the user table
		#$this->call('CreateUsersSeeder');

		// add some channels to the users
		#$this->call('AddUserChannelsSeeder');

		// add some random articles to the database
		#$this->call('AddArticlesSeeder');

		// attach the new articles to some categories
		#$this->call('AddCategoryArticleSeeder');

		$this->call('AddSponsorsSeeder');
	}

	private function cleanDatabase()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0');

		foreach($this->tables AS $tableName)
		{
			DB::table($tableName)->truncate();
		}

		DB::statement('SET FOREIGN_KEY_CHECKS=1');
	}

}
