<?php

namespace FMTAES;

interface JobRepository {

    public function getJobsBetweenDates($start_date, $end_date);
    public function jobsBetweenDates($start_date, $end_date);
    public function getSuppliersWithAllocatedJobs($jobs);
    public function getMaxJobNumber($start_date, $end_date);

}