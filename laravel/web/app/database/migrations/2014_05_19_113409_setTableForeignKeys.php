<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetTableForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('article', function($table)
		{
		    $table->foreign('content_type')->references('id')->on('content_type');
			$table->foreign('sponsor_id')->references('id')->on('sponsor');
			$table->foreign('event_id')->references('id')->on('event');
		});

		Schema::table('article_image', function($table)
		{
			$table->foreign('article_id')->references('id')->on('article');
			$table->foreign('image_id')->references('id')->on('asset');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Schema::table('article', function($table)
		// {
		// 	$table->dropForeign('article_content_type_foreign');
		// 	$table->dropForeign('article_sponsor_id_foreign');
		// 	$table->dropForeign('article_event_id_foreign');
		// });

		Schema::table('article_image', function($table)
		{
			//$table->dropForeign('article_image_article_id_foreign');
			//$table->dropForeign('article_image_image_id_foreign');
		});
	}

}
