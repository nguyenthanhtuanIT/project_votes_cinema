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
    Route::post('ticket_of_user', 'ChooseChairsController@ticketOfUser');
    //  status_vote_now
    Route::get('status_vote', 'VotesController@showStatusVote');
    //user choose chairs
    Route::resource('choose_chairs', 'ChooseChairsController')->only('store', 'update');
    //user voting
    Route::resource('votedetails', 'VoteDetailsController');
    // //check voted
    Route::post('check_voted', 'VoteDetailsController@checkVoted');
    Route::resource('registers', 'RegistersController');
    // //check register
    Route::post('check_register', 'RegistersController@checkRegistered');
    Route::post('un_register', 'RegistersController@unRegister');
    Route::post('guest_refuse', 'RegistersController@guestRefuses');
    // //get diagram_chairs by votes
    //Route::post('diagrams_by_vote', 'DiagramsController@diagramChairByVote');
    //Route::post('chairs_bought', 'ChairsController@getDiagramChairByVote');
    //check
    Route::post('check_user_choose_chair', 'ChooseChairsController@checkUserChoosed'); //
    Route::resource('blogs', 'BlogsController')->only('index');
    Route::post('update_status_chair', 'ChairsController@updateStatusChair');
    Route::post('re_choose_chair', 'ChooseChairsController@reChooses');
    Route::post('film_to_register', 'FilmsController@getFilmToRegister');
    Route::post('list_users', 'UsersController@listUsers');
    Route::post('un_voted', 'VoteDetailsController@unVoted');
    Route::resource('statisticals', 'StatisticalsController');
    Route::post('infor_vote', 'VotesController@inforVotes');
    Route::get('user_comment/{blog_id}', 'CommentsController@getComments');
    Route::resource('comments', 'CommentsController')->only('store', 'update', 'destroy');
    //admin
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('users', 'UsersController');
        Route::resource('votes', 'VotesController');
        Route::resource('films', 'FilmsController');
        Route::resource('cinemas', 'CinemasController');
        Route::resource('rooms', 'RoomsController');
        Route::resource('diagrams', 'DiagramsController');
        Route::resource('votedetails', 'VoteDetailsController');
        Route::resource('registers', 'RegistersController');
        Route::post('rand', 'ChooseChairsController@randChairs');
        //excel
        Route::get('excel', 'RegistersController@Export');
        Route::resource('rands', 'RandomsController');
        Route::resource('blogs', 'BlogsController');
        Route::resource('chairs', 'ChairsController');
        Route::resource('comments', 'CommentsController');
        Route::resource('choose_chairs', 'ChooseChairsController')->only(['index', 'update', 'destroy']);
        //Route::post('search_films', 'FilmsController@getFilmsByDate');
        //return film to register user
        //Route::get('search', 'VotesController@searchByTitle');
    });
});
