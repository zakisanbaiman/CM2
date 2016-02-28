<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the `manages` table
		Schema::create('manages', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('model_name');
			$table->string('maker');
			$table->string('size');
			$table->string('color');
			$table->timestamp('buy_date');
			$table->string('etc');
			$table->string('model_image');
			$table->integer('create_user_id')->unsigned()->nullable();
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
		// Delete the `manages` table
		Schema::drop('manages');
	}

}
