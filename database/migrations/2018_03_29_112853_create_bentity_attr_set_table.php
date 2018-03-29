<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBentityAttrSetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bentity_attr_set', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('bentity_id')->nullable();
			$table->integer('tasktypes_id')->nullable();
			$table->dateTime('create_at')->nullable();
			$table->dateTime('update_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bentity_attr_set');
	}

}
