<?php

class CampaignsTableSeederTableSeeder extends Seeder {

	public function run()
	{
        // php artisan db:seed --database=fmtdb

		// Uncomment the below to wipe the table clean before populating
		DB::table('campaigns')->truncate();

		$campaigns = array(

		);

		// Uncomment the below to run the seeder
		// DB::table('campaigns')->insert($campaigns);
	}

}
