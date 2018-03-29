<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tag_id')->unsigned()->index('task_tags_tag_id_foreign');
			$table->integer('task_id')->unsigned()->index('task_tags_task_id_foreign');
			$table->integer('user_id');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('task_tags');
	}

}
