<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table)
		{
			$table->increments('id',10)->unsigned();
			$table->string('article', 255);
			$table->integer('user_id')->default(0);
			$table->integer('like')->default(0);
			$table->timestamp('created_at')->nullable()->default('0000-00-00 00:00:00');
			$table->timestamp('updated_at')->nullable()->default('0000-00-00 00:00:00');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('articles');
	}

}
