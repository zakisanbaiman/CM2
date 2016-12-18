<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOauthToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Update the users table for OAuth
		Schema::table('users', function($table)
		{
			$table->string('oa_flags')->nullable();
			$table->string('oa_id')->nullable();
			$table->string('oa_email')->nullable();
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
			$table->dropColumn('oa_flags');
			$table->dropColumn('oa_id');
			$table->dropColumn('oa_email');
		});
	}

}
