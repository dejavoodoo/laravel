<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserJsdbSuppliersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // Many JSBD Supplier ID's to one User ID (eg. If the user controls multiple suppliers in the jobs system)
        Schema::create('user_jsdb_suppliers', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('jsdb_supp_id');
            $table->string('supp_name');
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
		Schema::drop('user_jsdb_suppliers');
	}

}
