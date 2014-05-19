<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article', function(Blueprint $table)
		{
			// set the storage engine for the table
			$table->engine = 'InnoDB';

			// define the columns

			$table->increments('id')->unsigned();
			$table->integer('content_type')->unsigned();
			$table->integer('sponsor_id')->unsigned()->nullable();
			$table->integer('event_id')->unsigned()->nullable();
			$table->integer('author_id')->unsigned()->nullable();
			$table->string('title', 255);
			$table->string('sef_name', 255);
			$table->string('sub_heading', 150);
			$table->text('body');
			$table->string('postcode', 15);
			$table->string('lat', 20);
			$table->string('lon', 20);
			$table->string('area', 75);
			$table->integer('impressions');
			$table->tinyInteger('is_active')->default(true);
			$table->tinyInteger('is_featured')->default(false);
			$table->tinyInteger('is_picked')->default(false);
			$table->tinyInteger('is_deleted')->default(false);
			$table->tinyInteger('is_comments')->default(false);
			$table->tinyInteger('is_approved')->default(false);
			$table->dateTime('published');
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
		Schema::drop('article');
	}
}
