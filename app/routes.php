<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/test', function()
{
    return View::make('portal.index');
});

Route::get('/jobs', array('as' => 'jobs', function()
{
   return View::make('portal.pages.jobs');
}));

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
    $users_and_customers = $UserHelpers->getUsersWithCustomers();

    $users_array = $UserHelpers->mergeUsersWithCustsAndSupps($users_and_customers, $user_customers, $user_suppliers);

    //Helpers::prePrintR(DB::connection('fmtdb')->getQueryLog());

    return Helpers::prePrintR($users_array);

});

Route::get('/testing/user', function()
{
    // Create a static user for easy login
    $user = User::create([
        'username' => 'dejavoodoo',
        'email' => 'insanekilroy@gmail.com',
        'password' => Hash::make('abc123'),
        'first_name' => 'Scott',
        'last_name' => 'Smith',
        'company_name' => 'Bobs Transport',
    ]);

    Helpers::prePrintR($user);

    echo '<br><br><br>';
    echo $user->id;

    $deathrow_user = User::find($user->id);
    $deathrow_user->delete();
});