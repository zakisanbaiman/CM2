<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('friends', function(Blueprint $table)
		{
	    $table->increments('id',10)->unsigned();
	    $table->integer('user_id')->default(0);
	    $table->integer('friend_id')->default(0);
	    $table->string('approval', 1);
	    $table->timestamp('created_at', 255)->nullable();
	    $table->timestamp('updated_at', 255)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('friends');
	}

}
