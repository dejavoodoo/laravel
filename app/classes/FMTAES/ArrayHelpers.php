<?php

namespace FMTAES;

use Whoops\Exception\ErrorException;

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

    /*
     * Groups user emails by user ID
     *
     * @param   Eloquent\Collection $users
     * @param   Eloquent\Collection $user_emails
     *
     * @return  array   $output
     */
    public static function createUserEmailsArrayGroupedByUser($users, $user_emails)
    {
        $output = [];
        foreach($users as $user)
        {
            foreach($user_emails as $email)
            {
                if($user->id == $email->user_id)
                {
                    $output[$user->id]['user_id'] = $user->id;
                    $output[$user->id]['primary_email'] = $user->email;
                    $output[$user->id]['emails_array'][] = $email->email;
                }
            }
        }

        return $output;
    }

    /*
     * Groups user customers by user ID
     *
     * @param   Eloquent\Collection $users
     * @param   Eloquent\Collection $user_customers
     *
     * @return  array   $output
     */
    public static function createUserCustomersArrayGroupedByUser($users, $user_customers)
    {
        $output = [];
        foreach($users as $user)
        {
            foreach($user_customers as $cust)
            {
                if($user->id == $cust->user_id)
                {
                    $output[$user->id]['user_id'] = $user->id;
                    if($cust->jsdb_cust_id > 0)
                    {
                        if(!array_key_exists('jsdb_cust_id_array', $output[$user->id]))
                        {
                            $output[$user->id]['jsdb_cust_id_array'] = [];
                        }
                        if(!in_array($cust->jsdb_cust_id, $output[$user->id]['jsdb_cust_id_array']))
                        {
                            $output[$user->id]['jsdb_cust_id_array'][] = $cust->jsdb_cust_id;
                        }

                    }

                    if($cust->jsdb_sub_cust_id > 0)
                    {
                        if(!array_key_exists('jsdb_sub_cust_id_array', $output[$user->id]))
                        {
                            $output[$user->id]['jsdb_sub_cust_id_array'] = [];
                        }
                        if(!in_array($cust->jsdb_sub_cust_id, $output[$user->id]['jsdb_sub_cust_id_array']))
                        {
                            $output[$user->id]['jsdb_sub_cust_id_array'][] = $cust->jsdb_sub_cust_id;
                        }

                    }
                }
            }
        }
        return $output;
    }

    /*
     * Groups user suppliers by user ID
     *
     * @param   Eloquent\Collection $users
     * @param   Eloquent\Collection $user_suppliers
     *
     * @return  array   $output
     */
    public static function createUserSupplierArrayGroupedByUser($users, $user_suppliers)
    {
        $output = [];
        foreach($users as $user)
        {
            foreach($user_suppliers as $supp)
            {
                if($user->id == $supp->user_id)
                {
                    $output[$user->id]['user_id'] = $user->id;
                    if($supp->jsdb_supp_id > 0)
                    {
                        if(!array_key_exists('jsdb_supp_id_array', $output[$user->id]))
                        {
                            $output[$user->id]['jsdb_supp_id_array'] = [];
                        }
                        if(!in_array($supp->jsdb_supp_id, $output[$user->id]['jsdb_supp_id_array']))
                        {
                            $output[$user->id]['jsdb_supp_id_array'][] = $supp->jsdb_supp_id;
                        }

                    }
                }
            }
        }
        return $output;
    }

    /*
     * Merge arrays into the same parent array
     *
     * @params  ... arrays
     *
     * @return  array   $output
     */
    public static function mergeUserEmailsCustomerSuppliers($users_array, $user_email_groups, $user_customer_groups, $user_supplier_groups)
    {
        // We are building this array:
        /*$output[$user_id] = [
            'user_id',
            'primary_email',
            'emails_array',
            'jsdb_cust_id_array',
            'jsdb_sub_cust_id_array',
            'jsdb_supp_id_array'
        ]*/
        $output = [];

        foreach($users_array as $u)
        {
            $output[$u['id']] = $u;

            foreach($user_email_groups as $e)
                if($u['id'] == $e['user_id'])
                    foreach($e as $eek => $eev)
                        $output[$u['id']][$eek] = $eev;

            foreach($user_customer_groups as $c)
                if($u['id'] == $c['user_id'])
                    foreach($c as $cck => $ccv)
                        $output[$u['id']][$cck] = $ccv;

            foreach($user_supplier_groups as $s)
                if($u['id'] == $s['user_id'])
                    foreach($s as $ssk => $ssv)
                        $output[$u['id']][$ssk] = $ssv;
        }
        return $output;
    }

}