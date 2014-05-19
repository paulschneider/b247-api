<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event', function(Blueprint $table)
		{

			// set the storage engine for the table

			$table->engine = 'InnoDB';

			// define the columns

			$table->increments('id')->unsigned();
			$table->integer('venue_id')->unsigned();
			$table->string('title', 150);
			$table->string('sef_name', 150);
			$table->date('show_date');
			$table->time('show_time');
			$table->float('price');
			$table->string('url', 150);
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
		Schema::drop('event');
	}

}
