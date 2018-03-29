<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogStatTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log_stat', function(Blueprint $table)
		{
			$table->string('name')->nullable();
			$table->string('en', 2)->default('');
			$table->string('prod_sku', 50)->nullable();
			$table->string('web_in', 200)->nullable();
			$table->string('web_dir', 200)->nullable();
			$table->text('type_a', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('log_stat');
	}

}
