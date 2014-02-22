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

    public function getJobsBetweenDates($start_date, $end_date)
    {
        // Get all jobs between start_date and end_date
        $jobs = $this->jobsBetweenDates($start_date, $end_date)->get();
        return $jobs;
        //return \Helpers::prePrintR($jobs);
    }

    public function jobsBetweenDates($start_date, $end_date)
    {
        $jobs = $this->job
            ->whereBetween('DateAPPR', [$start_date, $end_date])
            ->select([
                'JobNo',
                'DateAPPR',
                'CustID',
                'SubCustID'
            ]);
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
        $supp_collection = new \Illuminate\Support\Collection;
        foreach($jobs as $job)
        {
            $supp = $this->jobSuppCall
                ->select(['SuppID', 'JobNo'])
                ->where('JobNo', $job->JobNo)
                ->get();

            $supp_collection = $supp_collection->merge($supp);
        }
        return $supp_collection;
    }

    public function getMaxJobNumber($start_date, $end_date)
    {
        return $this->jobsBetweenDates($start_date, $end_date)->max('JobNo');
    }

    public function getMinJobNumber($start_date, $end_date)
    {
        return $this->jobsBetweenDates($start_date, $end_date)->min('JobNo');
    }

}