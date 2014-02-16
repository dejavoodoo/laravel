<?php

class JobHelpers {

    public function __construct(JSJob $job)
    {
        $this->job = $job;
    }

    public function get_jobs_between_dates($start_date, $end_date)
    {
        Log::info("Getting jobs between $start_date and $end_date...");

        if(!Helpers::isValidSQLDate($start_date) || !Helpers::isValidSQLDate($end_date)) {
            Log::error("Invalid start date: $start_date");
            die('Invalid SQL date provided.');
        }

        $jobs = $this->job->whereBetween('DateAPPR', array($start_date, $end_date))->get();

        return $jobs;
    }

}
