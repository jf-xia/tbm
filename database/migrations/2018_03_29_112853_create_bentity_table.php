<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBentityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bentity', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name');
			$table->string('context')->nullable();
			$table->dateTime('create_at')->nullable();
			$table->dateTime('update_at')->nullable();
			$table->integer('tasktypes_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bentity');
	}

}
