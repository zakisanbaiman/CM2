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