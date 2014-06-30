<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('channel', function(Blueprint $table)
		{

			// set the storage engine for the table

			$table->engine = 'InnoDB';

			// define the columns

			$table->increments('id')->unsigned();
			$table->integer('content_type')->unsigned();
			$table->integer('parent_channel')->unsigned();
			$table->integer('icon_img_id')->unsigned();
			$table->string('name', 100);
			$table->string('sef_name', 100);
			$table->string('colour', 45);
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
		Schema::drop('channel');
	}

}
