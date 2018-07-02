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

// Later should be changed to be the main page so the url will be doodleon.com/
Route::get('/', function () {
    return view('home');
});

Route::get('/drawingapp', function () {
    return view('drawingapp');
})->name('drawingapp');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::get('/userdrawings', function () {
    return view('userdrawings');
})->name('userdrawings');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

