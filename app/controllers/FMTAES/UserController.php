<?php

namespace FMTAES;

class UserController extends \BaseController {

    protected $users;
    protected $jobs;
    protected $user_emails;

    public function __construct(
        UserRepository $users,
        JobRepository $jobs,
        UserEmailsRepository $user_emails
    )
    {
        $this->users = $users;
        $this->jobs = $jobs;
        $this->user_emails = $user_emails;
    }

    public function showUsers()
    {
        //$user_customers = $this->users->getUserCustomers();

        //$user_suppliers = $this->users->getUserSuppliers();

        //$user_emails = $this->users->getUserEmails();

        //$users_and_customers = $this->users->getUsersWithCustomers();

        //$jobs_array = $this->jobs->getJobsBetweenDates('2012-01-01', '2012-12-31');

        //$users_array = $this->users->mergeUsersWith($users_and_customers, $user_customers, $user_suppliers, $user_emails, $jobs_array);

        //$users_array = $this->users->getUsers();



        $users = $this->users->getUsers();
        $user_emails = $this->user_emails->getAllUserEmails();
        $user_customers = $this->users->getUserCustomers();
        $user_suppliers = $this->users->getUserSuppliers();
        $user_jobs = $this->jobs->getJobsBetweenDates('2008-01-01', '2008-03-02');

        // Only include those SuppID's from $allocated_suppliers where the SuppID is associated with a user
        $jobs_with_suppliers = $this->jobs->getSuppliersWithAllocatedJobs($user_jobs);

        //return \Helpers::prePrintR($user_suppliers);

        $customer_jobs = ArrayHelpers::createJobsArrayGroupedByCustOrSupp($user_jobs, $user_customers, 'CustID', 'JobNo');
        $sub_customer_jobs = ArrayHelpers::createJobsArrayGroupedByCustOrSupp($user_jobs, $user_customers, 'SubCustID', 'JobNo');
        $supplier_jobs = ArrayHelpers::createJobsArrayGroupedByCustOrSupp($jobs_with_suppliers, $user_suppliers, 'SuppID', 'JobNo');

        $cust_id_jobs = ArrayHelpers::groupJobsOnIds($customer_jobs, 'CustID');
        $subcust_id_jobs = ArrayHelpers::groupJobsOnIds($sub_customer_jobs, 'SubCustID');
        $supp_id_jobs = ArrayHelpers::groupJobsOnIds($supplier_jobs, 'SuppID');

        $merged_groups = array_merge($cust_id_jobs, $subcust_id_jobs, $supp_id_jobs);

        echo 'Max memory used: ' . \Helpers::formatBytes(memory_get_peak_usage()) . '<br>';


        return \Helpers::prePrintR($merged_groups);
    }

    public function showCustomers()
    {
        $user_customers = $this->users->getUserCustomers();
        return \Helpers::prePrintR($user_customers);
    }

}