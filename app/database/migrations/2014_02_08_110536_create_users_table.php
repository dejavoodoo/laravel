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
        // Artisan Command:
        // php artisan migrate --env=local --database=fmtdb

		Schema::create('users', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company_name');

            $table->integer('parent_id');
            $table->integer('lft');
            $table->integer('rgt');
            $table->integer('depth');
            $table->timestamps();

            $table->index('parent_id');
            $table->index('lft');
            $table->index('rgt');
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
