<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->text('content', 65535)->nullable();
			$table->decimal('hours', 2, 1)->unsigned()->nullable()->default(0.0);
			$table->integer('price')->unsigned()->nullable()->default(00000000000);
			$table->dateTime('end_at')->nullable();
			$table->string('informed')->nullable();
			$table->integer('assigned_to')->nullable();
			$table->integer('task_id')->unsigned()->index('task_id_btree');
			$table->integer('product_id')->unsigned();
			$table->integer('devsuite_id')->unsigned();
			$table->integer('project_id')->unsigned()->default(00000000000);
			$table->integer('user_id')->default(0);
			$table->integer('taskstatus_id')->default(0);
			$table->integer('tasktype_id')->default(0);
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
		Schema::drop('tasks');
	}

}
