<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserJsdbCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // Many JSBD Customer ID's to one User ID (eg. If the user controls multiple customers in the jobs system)
        Schema::create('user_jsdb_customers', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id');
            $table->integer('jsdb_cust_id');
            $table->integer('jsdb_sub_cust_id');
            $table->string('cust_name');
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
		Schema::drop('user_jsdb_customers');
	}

}
