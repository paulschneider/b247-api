<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgeGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('age_group', function(Blueprint $table)
		{
			// set the storage engine for the table

			$table->engine = 'InnoDB';

			// define the columns

			$table->increments('id')->unsigned();
			$table->string('range', 45);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('age_group');
	}

}
