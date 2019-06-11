<?php

Route::group(['prefix' => 'v1'], function () {
    Route::post('auth/google', 'Auth\AuthGoogleController@login');
    Route::post('register', 'UsersController@register');
    Route::get('list_films', 'FilmsController@listFilmToVote');
});
Route::group(['prefix' => 'v1'], function () {
    Route::resource('blogs', 'BlogsController');
    //user information
    Route::get('me', 'UsersController@me');
    // //auth
    Route::post('auth/logout', 'Auth\AuthController@logout');
    // //chair
    // Route::get('user_choose_chair', 'ChooseChairsController@choose');
    // //sum ticket
    // Route::post('total_ticket', 'FilmsController@getTotalTicket');
    //  status_vote_now
    Route::get('status_vote', 'VotesController@showStatusVote');
    // //user choose chairs
    // Route::resource('choose_chairs', 'ChooseChairsController')->only('store');
    // //user voting
    Route::resource('votedetails', 'VoteDetailsController')->only('store', 'destroy');
    // //check voted
    Route::post('check_voted', 'VoteDetailsController@checkVoted');
    Route::resource('registers', 'RegistersController'); //->only(['store', 'destroy', 'update']);
    // //check register
    Route::post('check_register', 'RegistersController@checkRegistered');
    Route::post('un_register', 'RegistersController@unRegister');
    // //get diagram_chairs by votes
    // Route::post('chairs_by_vote', 'ChairsController@getDiagramChairByVote');
    // Route::post('update_status_chair', 'ChairsController@updateStatusChair');
    // //check
    // Route::post('check_user_choose_chair', 'ChooseChairsController@checkUserChooed');
    Route::post('film_to_register', 'FilmsController@getFilmToRegister');
    Route::post('list_users', 'UsersController@listUsers');
    Route::post('un_voted', 'VoteDetailsController@unVoted');
    Route::resource('statisticals', 'StatisticalsController');
    //admin
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('users', 'UsersController');
        Route::resource('votes', 'VotesController');
        Route::resource('films', 'FilmsController');
        Route::resource('cinemas', 'CinemasController');
        Route::resource('rooms', 'RoomsController');
        Route::resource('diagrams', 'DiagramsController');
        Route::resource('votedetails', 'VoteDetailsController')->only(['index', 'destroy', 'update']);

        //excel
        //Route::get('excel', 'RegistersController@Export');
        Route::resource('blogs', 'BlogsController');
        Route::resource('chairs', 'ChairsController');
        Route::resource('choose_chairs', 'ChooseChairsController')->only(['index', 'update', 'destroy']);
        //Route::post('search_films', 'FilmsController@getFilmsByDate');
        //return film to register user
        //Route::get('search', 'VotesController@searchByTitle');
    });
});
