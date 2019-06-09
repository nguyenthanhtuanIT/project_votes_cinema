<?php

Route::group(['prefix' => 'v1'], function () {
    Route::post('auth/google', 'Auth\AuthGoogleController@login');
    Route::post('register', 'UsersController@register');
    Route::get('list_films', 'FilmsController@listFilmToVote');
});
Route::group(['prefix' => 'v1'], function () {
    //Route::resource('registers', 'RegistersController')->only('store');
    //user information
    //Route::get('me', 'UsersController@me');
    // //auth
    // Route::post('auth/logout', 'Auth\AuthController@logout');
    // //chair
    // Route::get('user_choose_chair', 'ChooseChairsController@choose');
    // //sum ticket
    // Route::post('total_ticket', 'FilmsController@getTotalTicket');
    // //status_vote_now
    Route::get('status_vote', 'VotesController@showStatusVote');
    // //user choose chairs
    // Route::resource('choose_chairs', 'ChooseChairsController')->only('store');
    // //user voting
    Route::resource('votedetails', 'VoteDetailsController')->only('store', 'destroy');
    // //check voted
    Route::post('check_voted', 'VoteDetailsController@checkVoted');
    Route::resource('registers', 'RegistersController'); //->only(['store', 'destroy', 'update']);
    // //check register
    // Route::post('check_register', 'RegistersController@checkRegistered');
    // //get diagram_chairs by votes
    // Route::post('chairs_by_vote', 'ChairsController@getDiagramChairByVote');
    // Route::post('update_status_chair', 'ChairsController@updateStatusChair');
    // //check
    // Route::post('check_user_choose_chair', 'ChooseChairsController@checkUserChooed');
    Route::post('film_to_register', 'FilmsController@getFilmToRegister');
    // Route::get('list_film_to_register', 'FilmsController@listMaxVote');

    //admin
    Route::group(['prefix' => 'admin'], function () {
        //users
        Route::resource('users', 'UsersController');
        //votes
        Route::resource('votes', 'VotesController');
        //film
        Route::resource('films', 'FilmsController');
        //cinema
        Route::resource('cinemas', 'CinemasController');
        //room
        Route::resource('rooms', 'RoomsController');
        //diagram
        Route::resource('diagrams', 'DiagramsController');
        // votedetail
        Route::resource('votedetails', 'VoteDetailsController')->only(['index', 'destroy', 'update']);

        //excel
        //Route::get('excel', 'RegistersController@Export');
        //blog
        //Route::resource('blogs', 'BlogsController');
        //chair
        Route::resource('chairs', 'ChairsController');
        //admin choose chairs
        Route::resource('choose_chairs', 'ChooseChairsController')->only(['index', 'update', 'destroy']);
        //Route::post('search_films', 'FilmsController@getFilmsByDate');
        //return film to register user
        //Route::get('search', 'VotesController@searchByTitle');
    });
});
