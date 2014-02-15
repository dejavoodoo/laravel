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
        return $this->jobs->getJobsBetweenDates($start_date, $end_date);
    }

}