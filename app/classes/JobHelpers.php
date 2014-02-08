<?php

class JobHelpers {

    public function __construct()
    {

    }

    public static function get_jobs_between_dates($start_date, $end_date)
    {
        Log::info("Getting jobs between $start_date and $end_date...");

        if(!Helpers::isValidSQLDate($start_date) || !Helpers::isValidSQLDate($end_date)) {
            Log::error("Invalid start date: $start_date");
            die('Invalid SQL date provided.');
        }

        $Job = new \Job;
        $jobs = $Job->whereBetween('DateAPPR', array($start_date, $end_date))->get();
/*        $jobs = $Job->has('customer')->get();*/


        return Helpers::prePrintR($jobs);
    }

}
