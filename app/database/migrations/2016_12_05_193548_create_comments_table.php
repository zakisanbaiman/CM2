<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table)
		{
			$table->increments('id',10)->unsigned();
			$table->integer('article_id')->default(0);
			$table->string('comment', 255);
			$table->integer('user_id')->default(0);
			$table->integer('like')->default(0);
			$table->integer('parent_id')->nullable();
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
		Schema::drop('comments');
	}

}
