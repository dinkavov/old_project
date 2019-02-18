<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCarTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('car', function(Blueprint $table)
		{
			$table->foreign('model_id', 'car_ibfk_1')->references('id')->on('car_modtype')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('car', function(Blueprint $table)
		{
			$table->dropForeign('car_ibfk_1');
		});
	}

}
