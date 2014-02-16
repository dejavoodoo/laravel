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
        // Get all jobs between start_date and end_date
        $jobs = $this->job->whereBetween('DateAPPR', array($start_date, $end_date))->get()->toArray();

        return \Helpers::prePrintR($jobs);
    }

}