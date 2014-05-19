<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetForeignKeyConstraints extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('article', function(Blueprint $table){


			$table->foreign('content_type')->references('id')->on('content_type');
			$table->dropForeign('content_type_id_foreign');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('article', function(Blueprint $table){

			$table->dropForeign('content_type_id_foreign');

		});
	}

}
