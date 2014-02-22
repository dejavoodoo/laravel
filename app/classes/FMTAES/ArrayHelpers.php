<?php

namespace FMTAES;

class ArrayHelpers {

    /*
     * Groups job numbers by customer ID
     *
     * Returns array
     */
    public static function groupJobsOnIds($array, $key_column = 'CustID', $group_column = 'JobNo')
    {
        $grouped = [];
        foreach($array as $a)
        {
            $cust_id = $a[$key_column];
            if (isset($grouped[$cust_id]))
                array_push($grouped[$cust_id][$group_column], $a[$group_column]);
            else
                $grouped[$cust_id] = [$key_column => $cust_id, $group_column => [$a[$group_column]]];
        }
        return $grouped;
    }

    public static function recursiveGrouping($array, $output_array = [])
    {
        foreach($array as $a)
        {
            if(!array_key_exists('SuppID',$a))
                $output_array = self::recursiveGrouping($a, $output_array);
            else
                $output_array[] = ['SuppID' => $a['SuppID'], 'JobNo' => $a['JobNo']];
        }
        return $output_array;
    }

    public static function createJobsArrayGroupedByCustOrSupp($jobs_array, $user_customers_array, $field_name1 = 'CustID', $field_name2 = 'JobNo')
    {
        $customer_jobs = [];
        foreach($jobs_array as $job)
        {
            foreach($user_customers_array as $user_cust)
            {
                if($field_name1 == 'CustID')
                    if($job->CustID > 0 && $user_cust->jsdb_cust_id == $job->CustID)
                        $customer_jobs[] = [$field_name1 => $job->CustID, $field_name2 => $job->JobNo];

                if($field_name1 == 'SubCustID')
                    if($job->SubCustID > 0 && $user_cust->jsdb_sub_cust_id == $job->SubCustID)
                        $customer_jobs[] = [$field_name1 => $job->SubCustID, $field_name2 => $job->JobNo];

                if($field_name1 == 'SuppID')
                    if($job->SuppID > 0 && $user_cust->jsdb_supp_id == $job->SuppID)
                        $customer_jobs[] = [$field_name1 => $job->SuppID, $field_name2 => $job->JobNo];
            }
        }
        return $customer_jobs;
    }

}