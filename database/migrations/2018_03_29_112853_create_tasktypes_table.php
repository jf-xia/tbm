<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasktypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasktypes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('color');
			$table->integer('assigned_to');
			$table->smallInteger('multi_assigned')->unsigned()->nullable()->default(00000);
			$table->smallInteger('product_required')->nullable()->default(0);
			$table->smallInteger('project_required')->nullable()->default(0);
			$table->smallInteger('comment_required')->unsigned()->nullable();
			$table->integer('user_id');
			$table->string('tasktype_id')->nullable();
			$table->string('bentity_id')->nullable();
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
		Schema::drop('tasktypes');
	}

}
