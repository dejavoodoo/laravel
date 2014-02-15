<?php

namespace FMTAES;

class DbJobRepository implements JobRepository {

    protected $job;

    public function __construct(\JSJob $job)
    {
        $this->job = $job;
    }

    public function getJobsBetweenDates($start_date, $end_date)
    {
/*        if(!\Helpers::isValidSQLDate($start_date) || !\Helpers::isValidSQLDate($end_date)) {
            Log::error("Invalid start date: $start_date");
            die('Invalid SQL date provided.');
        }*/

        // Check if start date is valid
        $validator = \Helpers::isValidSqlDate($start_date);
        if($validator->fails())
            // todo: Log
            return 'Bad start date!';

        // Check if end date is valid
        $validator = \Helpers::isValidSqlDate($end_date);
        if($validator->fails())
            // todo: Log
            return 'Bad end date!';

        // Get all jobs between start_date and end_date
        $jobs = $this->job->whereBetween('DateAPPR', array($start_date, $end_date))->get()->toArray();

        return \Helpers::prePrintR($jobs);
    }

}