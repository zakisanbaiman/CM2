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
	return View::make('frontend/home/index');
});

Route::get('/home', array('as' => 'home', 'uses' => function()
{
	return Redirect::to('/');
}));

/*
|--------------------------------------------------------------------------
| Authentication and Authorization Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'auth'), function()
{
	# Login
	Route::get('login', array('as' => 'login', 'uses' => 'AuthController@getLogin'));
	Route::post('login', 'AuthController@postLogin');

	# Register
	Route::get('signup', array('as' => 'signup', 'uses' => 'AuthController@getSignup'));
	Route::post('signup', 'AuthController@postSignup');

	# Account Activation
	Route::get('activate/{activationCode}', array('as' => 'activate', 'uses' => 'AuthController@getActivate'));

	# Forgot Password
	Route::get('forgot-password', array('as' => 'forgot-password', 'uses' => 'AuthController@getForgotPassword'));
	Route::post('forgot-password', 'AuthController@postForgotPassword');

	# Forgot Password Confirmation
	Route::get('forgot-password/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'AuthController@getForgotPasswordConfirm'));
	Route::post('forgot-password/{passwordResetCode}', 'AuthController@postForgotPasswordConfirm');

	# Logout
	Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@getLogout'));

});

/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'account'), function()
{

	# Account Dashboard
	Route::get('/', array('as' => 'account', 'uses' => 'Controllers\Account\DashboardController@getIndex'));

	# Profile
	Route::get('profile', array('as' => 'profile', 'uses' => 'Controllers\Account\ProfileController@getIndex'));
	Route::post('profile', 'Controllers\Account\ProfileController@postIndex');

	# Change Password
	Route::get('change-password', array('as' => 'change-password', 'uses' => 'Controllers\Account\ChangePasswordController@getIndex'));
	Route::post('change-password', 'Controllers\Account\ChangePasswordController@postIndex');

	# Change Email
	Route::get('change-email', array('as' => 'change-email', 'uses' => 'Controllers\Account\ChangeEmailController@getIndex'));
	Route::post('change-email', 'Controllers\Account\ChangeEmailController@postIndex');

});

/*
|--------------------------------------------------------------------------
| Administration Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'admin'), function()
{

	# User Management
	Route::group(array('prefix' => 'users'), function()
	{
		Route::get('/', array('as' => 'users', 'uses' => 'Controllers\Admin\UsersController@getIndex'));
		Route::get('create', array('as' => 'create/user', 'uses' => 'Controllers\Admin\UsersController@getCreate'));
		Route::post('create', 'Controllers\Admin\UsersController@postCreate');
		Route::get('{userId}/edit', array('as' => 'update/user', 'uses' => 'Controllers\Admin\UsersController@getEdit'));
		Route::post('{userId}/edit', 'Controllers\Admin\UsersController@postEdit');
		Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'Controllers\Admin\UsersController@getDelete'));
		Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'Controllers\Admin\UsersController@getRestore'));
	});

	# Group Management
	Route::group(array('prefix' => 'groups'), function()
	{
		Route::get('/', array('as' => 'groups', 'uses' => 'Controllers\Admin\GroupsController@getIndex'));
		Route::get('create', array('as' => 'create/group', 'uses' => 'Controllers\Admin\GroupsController@getCreate'));
		Route::post('create', 'Controllers\Admin\GroupsController@postCreate');
		Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'Controllers\Admin\GroupsController@getEdit'));
		Route::post('{groupId}/edit', 'Controllers\Admin\GroupsController@postEdit');
		Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'Controllers\Admin\GroupsController@getDelete'));
		Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'Controllers\Admin\GroupsController@getRestore'));
	});

	# Dashboard
	Route::get('/', array('as' => 'admin', 'uses' => 'Controllers\Admin\DashboardController@getIndex'));

});


// manage
Route::get('/manage', 'ManageController@getManage');
Route::get('/manage/getManageObj', 'ManageController@getManageObj');
Route::post('/manage/updateManageObj', 'ManageController@updateManageObj');
Route::post('/manage/deleteManageObj', 'ManageController@deleteManageObj');
Route::post('/manage/insertManageObj', 'ManageController@insertManageObj');

Route::get('/manage/getManageOneObj', 'ManageController@getManageOneObj');

// manage list
Route::get('/manage/list', 'ManageController@getManageList');
Route::get('/manage/getManageObj', 'ManageController@getManageObj');
Route::post('/manage/updateManageObj', 'ManageController@updateManageObj');
Route::post('/manage/deleteManageObj', 'ManageController@deleteManageObj');
Route::post('/manage/insertManageObj', 'ManageController@insertManageObj');
Route::post('/manage/updateModelImage', 'ManageController@updateModelImage');

Route::post('/manage/getManageOrderObj', 'ManageController@getManageOrderObj');

Route::get('/manage/detail', 'ManageController@getManageDetail');
Route::get('/manage/getManageDetailObj', 'ManageController@getManageDetailObj');

/*
// profile
Route::get('/user/list', 'UserController@getUserList');
Route::get('/user/getUserListObj', 'UserController@getUserListObj');
Route::get('/user/profile', 'UserController@getProfile');
Route::get('/user/getProfileObj', 'UserController@getProfileObj');
Route::post('/user/updateProfileObj', 'UserController@updateProfileObj');
Route::post('/user/deleteProfileObj', 'UserController@deleteProfileObj');
*/

// csv
Route::get('/csv/import', 'CsvController@getCsvImport');
Route::post('/csv/updateCsvImage', 'CsvController@updateCsvImage');
