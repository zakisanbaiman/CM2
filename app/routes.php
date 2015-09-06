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
	return View::make('index');
});


// user
Route::get('/home', array('as' => 'home', 'uses' => function()
{
	return redirect::to('/');
}));
Route::get('/user/signup', array('as' => 'signup', 'uses' => 'AuthController@showSignUp'));
Route::get('/autu/signup', 'AuthController@showSignUp');
Route::post('/user/signup', 'AuthController@execSignUp');
Route::get('/user/login', array('as' => 'login', 'uses' => 'AuthController@showLogin'));
Route::post('/user/login', 'AuthController@execLogin');
Route::get('/user/logout', 'AuthController@logout');

// manage
Route::get('/manage', 'ManageController@getManage');
Route::get('/manage/getManageObj', 'ManageController@getManageObj');
Route::post('/manage/updateManageObj', 'ManageController@updateManageObj');
Route::post('/manage/deleteManageObj', 'ManageController@deleteManageObj');
Route::post('/manage/insertManageObj', 'ManageController@insertManageObj');

Route::get('/manage/getManageOneObj', 'ManageController@getManageOneObj');

// manage list（削除するかも）
Route::get('/manage/list', 'ManageController@getManageList');
Route::get('/manage/getManageObj', 'ManageController@getManageObj');
Route::post('/manage/updateManageObj', 'ManageController@updateManageObj');
Route::post('/manage/deleteManageObj', 'ManageController@deleteManageObj');
Route::post('/manage/insertManageObj', 'ManageController@insertManageObj');
Route::post('/manage/updateModelImage', 'ManageController@updateModelImage');

Route::get('/manage/detail', 'ManageController@getManageDetail');
Route::get('/manage/getManageDetailObj', 'ManageController@getManageDetailObj');

// profile
Route::get('/user/list', 'UserController@getUserList');
Route::get('/user/getUserListObj', 'UserController@getUserListObj');
Route::get('/user/profile', 'UserController@getProfile');
Route::get('/user/getProfileObj', 'UserController@getProfileObj');
Route::post('/user/updateProfileObj', 'UserController@updateProfileObj');
Route::post('/user/deleteProfileObj', 'UserController@deleteProfileObj');









