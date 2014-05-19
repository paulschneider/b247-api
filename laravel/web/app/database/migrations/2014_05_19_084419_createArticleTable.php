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
		Schema::table('article', function(Blueprint $table)
		{
			// set the storage engine for the table
			$table->engine = 'InnoDB';

			// define the columns

			$table->increments('id');
			$table->integer('content_type');
			$table->integer('sponsor_id')->nullable();
			$table->integer('event_id')->nullable();
			$table->integer('author_id')->nullable();
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

			// define foreign key constraints

			$table->foreign('content_type')->references('id')->on('content_type');
			$table->foreign('sponsor_id')->references('id')->on('sponsor');
			$table->foreign('event_id')->references('id')->on('event');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('article', function(Blueprint $table)
		{
			// Do nothing - this is the start
		});
	}

}
