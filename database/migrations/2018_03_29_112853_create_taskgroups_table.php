<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskgroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taskgroups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('task_id');
			$table->integer('user_id');
			$table->smallInteger('grade')->unsigned()->default(00000);
			$table->string('comment', 2500)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('taskgroups');
	}

}
