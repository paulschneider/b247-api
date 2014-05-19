<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('search', function(Blueprint $table)
		{

			// set the storage engine for the table

			$table->engine = 'InnoDB';

			// define the columns

			$table->increments('id')->unsigned();
			$table->string('term', 30);
			$table->string('device', 45);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('search');
	}

}
