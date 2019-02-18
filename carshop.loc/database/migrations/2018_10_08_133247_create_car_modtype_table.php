<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCarModtypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('car_modtype', function(Blueprint $table)
		{
			$table->integer('id')->primary();
			$table->integer('brand_id')->index('brand');
			$table->integer('hull_id')->index('hull');
			$table->integer('class_id')->index('class');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('car_modtype');
	}

}
