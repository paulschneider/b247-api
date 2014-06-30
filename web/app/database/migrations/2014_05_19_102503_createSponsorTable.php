<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sponsor', function(Blueprint $table)
		{
			// set the storage engine for the table

			$table->engine = 'InnoDB';

			// define the columns

			$table->increments('id')->unsigned();
			$table->integer('image_id')->unsigned();
			$table->string('title', 100);
			$table->string('url', 150);
			$table->dateTime('display_start');
			$table->dateTime('display_end');
			$table->integer('impressions')->nullable();
			$table->integer('clicks')->nullable();
			$table->tinyInteger('is_mobile')->default(false);
			$table->tinyInteger('is_tablet')->default(false);
			$table->tinyInteger('is_desktop')->default(true);
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
		Schema::drop('sponsor');
	}

}
