<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('/doodles', 'DoodlesController');
Route::resource('/settings', 'SettingsController');
Route::resource('/reports', 'ReportsController');
Route::resource('/votes', 'VotesController');
Route::resource('/comments', 'CommentsController');
Route::post('/doodles/vote/{id}', 'DoodlesController@updateVote');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/signature', 'SignatureController@store')->name('storesignature');
Route::post('/signature/{id}', 'SignatureController@edit')->name('editsignature');
Route::get('/signature/create', 'SignatureController@create')->name('createsignature');