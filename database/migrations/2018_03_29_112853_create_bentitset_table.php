<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBentitsetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bentitset', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('task_id')->nullable();
			$table->integer('ben_title_id')->nullable();
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
		Schema::drop('bentitset');
	}

}
