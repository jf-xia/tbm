<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTaskTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('task_tags', function(Blueprint $table)
		{
			$table->foreign('tag_id', 'task_tags_ibfk_1')->references('id')->on('tags')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('task_id', 'task_tags_ibfk_2')->references('id')->on('tasks')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('task_tags', function(Blueprint $table)
		{
			$table->dropForeign('task_tags_ibfk_1');
			$table->dropForeign('task_tags_ibfk_2');
		});
	}

}
