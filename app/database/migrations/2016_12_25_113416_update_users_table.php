<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Update the users table
		Schema::table('users', function($table)
		{
			$table->string('user_image', 255)->nullable()->default(null);
			$table->string('nickname', 255)->nullable()->default(null);
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
 	public function down()
	{
		// Update the users table
		Schema::table('users', function($table)
		{
			$table->dropColumn('user_image');
			$table->dropColumn('nickname');
		});

	}

}
