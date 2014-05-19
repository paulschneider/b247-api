<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleImageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_image', function(Blueprint $table)
		{
			// set the storage engine for the table

			$table->engine = 'InnoDB';

			// define the columns

			$table->increments('id')->unsigned();
			$table->integer('article_id')->unsigned();
			$table->integer('image_id')->unsigned();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('article_image');
	}

}
