<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('venue', function(Blueprint $table)
		{

			// set the storage engine for the table

			$table->engine = 'InnoDB';

			// define the columns

			$table->increments('id')->unsigned();
			$table->string('name', 100);
			$table->string('address_line_one', 50);
			$table->string('address_line_two', 50);
			$table->string('address_line_three', 50);
			$table->string('postcode', 15);
			$table->string('email', 150);
			$table->string('lat', 20);
			$table->string('lon', 20);
			$table->string('area', 75);
			$table->string('facebook', 75);
			$table->string('twitter', 75);
			$table->string('phone', 30);
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
		Schema::drop('venue');
	}

}
