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
        $start_date = '2008-01-01';
        $end_date = '2008-03-02';

        $user_customers = $this->users->getUserCustomers();
        $user_suppliers = $this->users->getUserSuppliers();
        $user_jobs = $this->jobs->getJobsBetweenDates($start_date, $end_date);
        $user_jobs_unfinished = $this->jobs->jobsBetweenDates($start_date, $end_date);

        // Only include those SuppID's from $allocated_suppliers where the SuppID is associated with a user
        $jobs_with_suppliers = $this->jobs->getSuppliersWithAllocatedJobs($user_jobs_unfinished);

        //return \Helpers::prePrintR($jobs_with_suppliers);

        $customer_jobs = ArrayHelpers::createJobsArrayGroupedByCustOrSupp($user_jobs, $user_customers, 'CustID', 'JobNo');
        $sub_customer_jobs = ArrayHelpers::createJobsArrayGroupedByCustOrSupp($user_jobs, $user_customers, 'SubCustID', 'JobNo');
        $supplier_jobs = ArrayHelpers::createJobsArrayGroupedByCustOrSupp($jobs_with_suppliers, $user_suppliers, 'SuppID', 'JobNo');

        $cust_id_jobs = ArrayHelpers::groupJobsOnIds($customer_jobs, 'CustID');
        $subcust_id_jobs = ArrayHelpers::groupJobsOnIds($sub_customer_jobs, 'SubCustID');
        $supp_id_jobs = ArrayHelpers::groupJobsOnIds($supplier_jobs, 'SuppID');

        $jobs_grouped_by_cust_or_supp_id_array = array_merge($cust_id_jobs, $subcust_id_jobs, $supp_id_jobs);

        /*
         * Foreach user, we need an array of:
         *
         **DONE** - Primary email (users.email)
         **DONE** - Secondary emails (user_emails.email)
         **DONE** - Customer ID's (user_jsdb_customers.jsdb_cust_id)
         **DONE** - Sub Customer ID's (user_jsdb_customers.jsdb_sub_cust_id)
         **DONE** - Supplier ID's (user_jsdb_suppliers.jsdb_supp_id)
         *
         * Foreach $merged_cust_supp_id_with_jobs_array,
         *      If CustID matches,
         *          Generate email containing job numbers
         *          Send the email
         *          Insert a record into the emails_sent table
         *          Delete that user from the users array
         */

        // Build an array of user emails, customer ID's and supplier ID's
        $users = $this->users->getUsers();
        $user_emails = $this->user_emails->getAllUserEmails();

        $users_array = $users->toArray();
        $user_email_groups = ArrayHelpers::createUserEmailsArrayGroupedByUser($users, $user_emails);
        $user_customer_groups = ArrayHelpers::createUserCustomersArrayGroupedByUser($users, $user_customers);
        $user_supplier_groups = ArrayHelpers::createUserSupplierArrayGroupedByUser($users, $user_suppliers);

        $user_details_grouped_by_user_id_array = ArrayHelpers::mergeUserEmailsCustomerSuppliers($users_array, $user_email_groups, $user_customer_groups, $user_supplier_groups);

        echo 'Max memory used: ' . \Helpers::formatBytes(memory_get_peak_usage()) . '<br>';
        return \Helpers::prePrintR($user_details_grouped_by_user_id_array);
    }

    public function showCustomers()
    {
        $user_customers = $this->users->getUserCustomers();
        return \Helpers::prePrintR($user_customers);
    }

}