<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // Artisan Command:
        // php artisan migrate --env=local --database=fmtdb
		Schema::create('campaigns', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('campaign_abbr');
            $table->string('campaign_name');
            $table->string('campaign_base_url');
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
