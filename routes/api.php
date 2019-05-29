<?php

Route::group(['prefix' => 'v1'], function () {
    //Route::post('auth/login', 'Auth\AuthController@login');
    Route::post('auth/google', 'Auth\AuthGoogleController@login');
    //Route::post('auth/facebook', 'Auth\AuthFacebookController@login');
    Route::post('password/forgot/request', 'Auth\ForgotPasswordController@getResetToken');
    Route::post('password/forgot/reset', 'Auth\ResetPasswordController@reset');
    Route::post('register', 'UsersController@register');
    //user information
    Route::get('me', 'UsersController@me');
    //auth
    Route::post('auth/logout', 'Auth\AuthController@logout');
    //password
    Route::post('password/change', 'UsersController@changePass');
    //films
    Route::get('list_films', 'FilmsController@listFilmToVote');
    Route::post('search_films', 'FilmsController@getFilmsByDate');
    //return film to register user
    Route::get('film_to_register', 'FilmsController@getFilmToRegister');

    //chair
    Route::get('user_choose_chair', 'ChooseChairsController@choose');
    Route::resource('choose_chairs', 'ChooseChairsController');
    //sum ticket
    Route::post('total_ticket', 'FilmsController@getTotalTicket');
    //status_vote_now
    Route::get('status_vote', 'VotesController@showStatusVote');
    //user choose chairs
    Route::resource('choose_chairs', 'ChooseChairsController')->only('store');
    //user voting
    Route::resource('votedetails', 'VoteDetailsController')->only('store');
    //check voted
    Route::post('check_voted', 'VoteDetailsController@checkVoted');
    //check register
    Route::post('check_register', 'RegistersController@checkRegistered');
});

Route::group(['prefix' => 'v1'], function () {
    //users
    Route::resource('users', 'UsersController');
    //votes
    Route::resource('votes', 'VotesController');
    Route::get('search', 'VotesController@searchByTitle');
    //film
    Route::resource('films', 'FilmsController');
    Route::get('list_film_to_register', 'FilmsController@listMaxVote');
    //cinema
    Route::resource('cinemas', 'CinemasController');
    //admin votedetail
    Route::resource('votedetails', 'VoteDetailsController')->only(['index', 'destroy', 'update']);
    // images
    Route::resource('images', 'ImagesController')->only(['store', 'destroy']);
    //register
    Route::resource('registers', 'RegistersController');
    //excel
    Route::get('excel', 'RegistersController@Export');
    //blog
    Route::resource('blogs', 'BlogsController');
    //cinema
    Route::resource('cinemas', 'CinemasController');
    //type-cinemas
    Route::resource('typecinemas', 'TypeCinemasController');
    //chair
    Route::resource('chairs', 'ChairsController');
    //admin choose chairs
    Route::resource('choose_chairs', 'ChooseChairsController')->only(['index', 'update', 'destroy']);
});
