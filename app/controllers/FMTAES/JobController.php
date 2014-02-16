<?php

namespace FMTAES;

class JobController extends \BaseController {

    protected $jobs;

    public function __construct(JobRepository $jobs)
    {
        $this->jobs = $jobs;
    }

    public function showJobs($start_date, $end_date)
    {
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

        return $this->jobs->getJobsBetweenDates($start_date, $end_date);
    }

}