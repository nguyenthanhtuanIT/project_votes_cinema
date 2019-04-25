<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

/**
 * Authorized resources
 */
Route::group(['prefix' => 'v1'], function () {
	Route::post('auth/login', 'Auth\AuthController@login');
	Route::post('auth/facebook', 'Auth\AuthFacebookController@login');
	Route::post('password/forgot/request', 'Auth\ForgotPasswordController@getResetToken');
	Route::post('password/forgot/reset', 'Auth\ResetPasswordController@reset');
	Route::post('register', 'UsersController@register');
});

Route::group(['prefix' => 'v1'], function () {
	//auth
	Route::post('auth/logout', 'Auth\AuthController@logout');
	//password
	Route::post('password/change', 'UsersController@changePass');
	//user information
	Route::get('me', 'UsersController@me');

	//users
	Route::resource('users', 'UsersController');
	Route::resource('register', 'RegistersController');
	Route::resource('cinema', 'CinemasController');
	Route::resource('type_cinema', 'TypeCinemasController');
	Route::resource('type_cinema_user', 'TypeCinemaUsersController');
	//promotions
	//promotions
	// images
	Route::resource('images', 'ImagesController')->only(['store', 'destroy']);
});
