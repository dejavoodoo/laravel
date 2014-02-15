<?php

namespace FMTAES;

interface JobRepository {

    public function getJobsBetweenDates($start_date, $end_date);

}