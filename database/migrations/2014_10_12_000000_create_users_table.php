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
			$table->increments('id');
			$table->text('num_id');		// C.C o NIT
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->enum('user_type', ['Super Admin', 'Admin', 'User', 'Provider']);
			$table->integer('role_id')->unsigned()->nullable();
			$table->rememberToken();
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
		Schema::drop('users');
	}

}
