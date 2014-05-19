<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			// set the storage engine for the table

			$table->engine = 'InnoDB';

			// define the columns

			$table->increments('id')->unsigned();
			$table->integer('age_group_id')->unsigned();
			$table->string('access_key', 45);
			$table->string('first_name', 75);
			$table->string('last_name', 45);
			$table->string('nickname', 45);
			$table->string('email', 150);
			$table->string('password', 65);
			$table->string('facebook', 75);
			$table->string('twitter', 75);
			$table->string('postcode', 15);
			$table->string('lat', 20);
			$table->string('lon', 20);
			$table->string('area', 75);
			$table->string('originating_ip', 30);
			$table->dateTime('last_login');
			$table->string('last_login_ip', 30);
			$table->tinyInteger('is_active')->default(true);
			$table->tinyInteger('is_deleted')->default(false);
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user');
	}

}
