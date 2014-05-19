<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordAppliedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('keyword_applied', function(Blueprint $table)
		{

			// set the storage engine for the table

			$table->engine = 'InnoDB';

			// define the columns

			$table->increments('id')->unsigned();
			$table->integer('keyword_id')->unsigned();
			$table->integer('content_type')->unsigned();
			$table->integer('resource_id')->unsigned();

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
		Schema::drop('keyword_applied');
	}

}
