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
//pacman 
Route::get('/pacman/index', array('as' => 'pacman', 'uses'=>'GamesController@pacmanIndex'));
//puzzele
Route::get('/2048/index', array('as' => 'puzzle', 'uses'=>'GamesController@puzzleIndex'));



//DTR

Route::get('/DTR/view', array('as' => 'view.login', 'uses'=>'ViewerController@viewLogin'));
Route::get('/DTR/change_pass', array('as' => 'change.pass', 'uses'=>'ViewerController@changePass'));

Route::post('/DTR/post_change_pass', array('as' => 'post.change.pass', 'uses'=>'ViewerController@postChangePassword'));