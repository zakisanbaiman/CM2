<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id',10)->unsigned();
			$table->string('email', 255);
			$table->string('password', 255);
			$table->text('permissions')->nullable()->default(null);
			$table->tinyInteger('activated')->default(0);
			$table->string('activation_code', 255)->nullable()->default(null);
			$table->timestamp('activated_at')->nullable()->default('0000-00-00 00:00:00');
			$table->timestamp('last_login')->nullable()->default('0000-00-00 00:00:00');
			$table->string('persist_code', 255)->nullable()->default(null);
			$table->string('reset_password_code', 255)->nullable()->default(null);
			$table->string('first_name', 255)->nullable()->default(null);
			$table->string('last_name', 255)->nullable()->default(null);
			$table->string('user_image', 255)->nullable()->default(null);
			$table->string('nickname', 255)->nullable()->default(null);
			$table->timestamp('created_at', 255)->default('0000-00-00 00:00:00');
			$table->timestamp('updated_at', 255)->default('0000-00-00 00:00:00');
			$table->string('deleted_at', 255)->nullable()->default(null);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
