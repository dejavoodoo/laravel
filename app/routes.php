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

/* FMT AES Testing */
Route::get('/show/users', 'FMTAES\UserController@showUsers');
Route::get('/show/customers', 'FMTAES\UserController@showCustomers');

Route::get('user/jobs', ['as' => 'jobs', function()
{
    $data = ['page_heading' => 'Jobs'];
    return View::make('portal.pages.jobs')->with(compact('data', 'jobs'));
}]);

Route::get('/show/jobs/{start_date}/{end_date}', 'FMTAES\JobController@showJobs');

// API
Route::group(['prefix' => 'api'], function()
{
    Route::get('jobs', ['as' => 'api_jobs', function()
    {
        $jobs = JSJob::paginate(15);
        return $jobs;
    }]);
});

Route::get('/testing/create-user', function()
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