<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogDbTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log_db', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('route')->nullable();
			$table->string('query', 8550)->nullable();
			$table->string('bindings')->nullable();
			$table->integer('time')->nullable();
			$table->dateTime('created_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('log_db');
	}

}
