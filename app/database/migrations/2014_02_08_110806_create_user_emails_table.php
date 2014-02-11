<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEmailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // Many emails to one user (eg. A user may have multiple email addresses for receiving job reports)
        Schema::create('user_emails', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id');
            $table->string('email');
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
		Schema::drop('user_emails');
	}

}
