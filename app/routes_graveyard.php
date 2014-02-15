<?php

Route::get('/testing/jobs/{startDate}/{endDate}', function($startDate, $endDate)
{
    $Job = new JSJob;
    $JobHelpers = new JobHelpers($Job);
    $User = new User;
    $UserHelpers = new UserHelpers($User);
    //$jobs = $JobHelpers->get_jobs_between_dates($startDate, $endDate);

    //Helpers::prePrintR($jobs);

    //$users = $UserHelpers->getUsers();

    //Helpers::prePrintR($users);

    //$users = $UserHelpers->getUsers();
    $user_customers = $UserHelpers->getUserCustomers();
    $user_suppliers = $UserHelpers->getUserSuppliers();
    $user_emails = $UserHelpers->getUserEmails();
    $users_and_customers = $UserHelpers->getUsersWithCustomers();

    $users_array = $UserHelpers->mergeUsersWith($users_and_customers, $user_customers, $user_suppliers, $user_emails);

    //Helpers::prePrintR(DB::connection('fmtdb')->getQueryLog());

    return Helpers::prePrintR($users_array);


});