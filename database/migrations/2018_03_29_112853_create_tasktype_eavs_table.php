<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasktypeEavsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasktype_eavs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tasktype_id');
			$table->string('code')->unique('eav_code_unique');
			$table->string('frontend_label');
			$table->string('frontend_input');
			$table->boolean('frontend_size');
			$table->boolean('is_required');
			$table->boolean('is_unique');
			$table->boolean('is_report');
			$table->string('option');
			$table->smallInteger('orderby')->default(0);
			$table->integer('user_id');
			$table->string('note')->nullable();
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
		Schema::drop('tasktype_eavs');
	}

}
