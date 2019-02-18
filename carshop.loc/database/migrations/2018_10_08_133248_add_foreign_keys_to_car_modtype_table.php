<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCarModtypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('car_modtype', function(Blueprint $table)
		{
			$table->foreign('brand_id', 'car_modtype_ibfk_1')->references('id')->on('brand')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('hull_id', 'car_modtype_ibfk_2')->references('id')->on('hull')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('class_id', 'car_modtype_ibfk_3')->references('id')->on('class')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('car_modtype', function(Blueprint $table)
		{
			$table->dropForeign('car_modtype_ibfk_1');
			$table->dropForeign('car_modtype_ibfk_2');
			$table->dropForeign('car_modtype_ibfk_3');
		});
	}

}
