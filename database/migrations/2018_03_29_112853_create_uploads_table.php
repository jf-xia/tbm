<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUploadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('uploads', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('tasktype_id');
			$table->string('file_name');
			$table->string('upload_ids', 5000)->nullable();
			$table->string('import_ids', 5000)->nullable();
			$table->string('error_ids', 1000)->nullable();
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
		Schema::drop('uploads');
	}

}
