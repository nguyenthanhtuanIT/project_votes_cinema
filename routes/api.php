<?php

Route::group(['prefix' => 'v1'], function () {
    Route::post('auth/google', 'Auth\AuthGoogleController@login');
    Route::post('register', 'UsersController@register');
    Route::get('list_films', 'FilmsController@listFilmToVote');
    Route::get('get_blogs', 'BlogsController@getBlog');
    Route::resource('blogs', 'BlogsController')->only('index', 'show');
});
Route::group(['prefix' => 'v1'], function () {
    //user information
    Route::get('me', 'UsersController@me');
    //auth
    Route::post('auth/logout', 'Auth\AuthController@logout');
    Route::post('ticket_of_user', 'ChooseChairsController@ticketOfUser');
    //  status_vote_now
    Route::get('status_vote', 'VotesController@showStatusVote');
    //user choose chairs
    Route::resource('choose_chairs', 'ChooseChairsController');
    //user voting
    Route::resource('votedetails', 'VoteDetailsController');
    // //check voted
    Route::post('check_voted', 'VoteDetailsController@checkVoted');
    Route::resource('registers', 'RegistersController');
    // //check register
    Route::post('check_register', 'RegistersController@checkRegistered');
    Route::post('un_register', 'RegistersController@unRegister');
    Route::post('guest_refuse', 'RegistersController@guestRefuses');
    Route::post('check_user_choose_chair', 'ChooseChairsController@checkUserChoosed'); //
    Route::post('update_status_chair', 'ChairsController@updateStatusChair');
    Route::post('re_choose_chair', 'ChooseChairsController@reChooses');
    Route::post('film_to_register', 'FilmsController@getFilmToRegister');
    Route::post('list_users', 'UsersController@listUsers');
    Route::post('un_voted', 'VoteDetailsController@unVoted');
    Route::resource('statisticals', 'StatisticalsController');
    Route::post('infor_vote', 'VotesController@inforVotes');
    Route::get('user_comment/{blog_id}', 'CommentsController@getComments');
    Route::resource('comments', 'CommentsController')->only('store', 'update', 'destroy');
    Route::post('search_blog', 'BlogsController@searchBlogByTitle');
    Route::get('amount_vote_films/{vote_id}', 'StatisticalsController@getAmountVote');
    //admin
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('users', 'UsersController');
        Route::resource('votes', 'VotesController');
        Route::resource('films', 'FilmsController');
        Route::resource('cinemas', 'CinemasController');
        Route::resource('rooms', 'RoomsController');
        Route::resource('diagrams', 'DiagramsController');
        Route::get('choose_chairs', 'ChooseChairsController@index');
        Route::delete('del_choose_chairs/{vote_id}', 'ChooseChairsController@deleteAll');
        Route::delete('del_chairs/{vote_id}', 'ChairsController@deleteAll');
        Route::resource('statisticals', 'StatisticalsController');
        Route::delete('del_statisticals/{vote_id}', 'StatisticalsController@deleteAll');
        Route::resource('votedetails', 'VoteDetailsController');
        Route::delete('del_votedetails/{vote_id}', 'VoteDetailsController@deleteAll');
        Route::delete('delete_all/{room_id}', 'DiagramsController@deleteAll');
        Route::delete('del_all/{vote_id}', 'RandomsController@deleteAll');
        Route::resource('votedetails', 'VoteDetailsController')->only('index', 'destroy');
        Route::resource('registers', 'RegistersController')->only('index', 'destroy');
        Route::post('rand', 'ChooseChairsController@randChairs');
        Route::get('infor_detail/{vote_id}', 'StatisticalsController@getInforByVote');
        Route::get('infor_list_vote', 'StatisticalsController@getInfor');
        Route::post('search_by_room', 'DiagramsController@searchByRoom');
        Route::get('excel/{vote_id}', 'RegistersController@Export');
        Route::resource('rands', 'RandomsController');
        Route::resource('blogs', 'BlogsController');
        Route::resource('chairs', 'ChairsController');
        Route::resource('comments', 'CommentsController');
        Route::resource('choose_chairs', 'ChooseChairsController')->only(['index', 'update', 'destroy']);
        Route::get('chair_rand_by_vote/{vote_id}', 'RandomsController@getChairsByVote');
        Route::get('chair_by_vote/{vote_id}', 'ChairsController@getDiagramChairByVote');
    });
});
