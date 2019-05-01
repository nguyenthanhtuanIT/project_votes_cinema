<?php

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
	//votes
	Route::resource('votes', 'VotesController');
	//film
	Route::resource('films', 'FilmsController');
	//votedetail
	Route::resource('votedetails', 'VoteDetailsController');
	// images
	Route::resource('images', 'ImagesController')->only(['store', 'destroy']);
	//register
	Route::resource('registers', 'RegistersController');
	Route::get('time', 'FilmsController@Time');
});
