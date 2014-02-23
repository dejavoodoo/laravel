<?php

namespace FMTAES;

class DbJobRepository implements JobRepository {

    protected $job;
    protected $jobSuppCall;
    protected $supplier;

    public function __construct
    (
        \JSJob $job,
        \JSJobSuppCall $jobSuppCall,
        \JSSupplier $supplier
    )
    {
        $this->job = $job;
        $this->jobSuppCall = $jobSuppCall;
        $this->supplier = $supplier;
    }

    /*
     * Get all jobs between start_date and end_date
     *
     * @param $start_date string
     * @param $end_date string
     *
     * @return Eloquent collection
     */
    public function getJobsBetweenDates($start_date, $end_date)
    {
        $jobs = $this
            ->jobsBetweenDates($start_date, $end_date)
            ->select(['JobNo','DateAPPR','CustID','SubCustID'])
            ->get();
        return $jobs;
    }

    public function jobsBetweenDates($start_date, $end_date)
    {
        $jobs = $this->job
            ->whereBetween('DateAPPR', [$start_date, $end_date]);
        return $jobs;
    }

    /*
     * For Each suppID, we want an array of associated job numbers
     *
     * @param $jobs Eloquent collection
     *
     * @return Eloquent collection
     */
    public function getSuppliersWithAllocatedJobs($jobs)
    {
        return $jobs
            ->join('JobSuppCalls', 'Jobs.JobNo', '=', 'JobSuppCalls.JobNo')
            ->select(['JobSuppCalls.SuppID', 'JobSuppCalls.JobNo'])
            ->get();
    }
    /*public function getSuppliersWithAllocatedJobs2($jobs)
    {
        $supp_collection = new \Illuminate\Support\Collection;
        foreach($jobs as $job)
        {
            $supp = $this->jobSuppCall->select(['SuppID', 'JobNo'])->where('JobNo', $job->JobNo)->get();
            $supp_collection = $supp_collection->merge($supp);
        }
        return $supp_collection;
        //return $this->jobSuppCall->all()->get(['SuppID', 'JobNo']);
    }*/


}