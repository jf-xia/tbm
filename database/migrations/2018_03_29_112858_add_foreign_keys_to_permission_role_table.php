<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPermissionRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('permission_role', function(Blueprint $table)
		{
			$table->foreign('permission_id', 'permission_role_ibfk_1')->references('id')->on('permissions')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('role_id', 'permission_role_ibfk_2')->references('id')->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('permission_role', function(Blueprint $table)
		{
			$table->dropForeign('permission_role_ibfk_1');
			$table->dropForeign('permission_role_ibfk_2');
		});
	}

}
