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
    return view('pages.home');
});

Route::get('/drawingapp', function () {
    return view('pages.drawingapp');
})->name('drawingapp');

Route::get('/settings', function () {
    return view('pages.settingscontents.account');
})->name('settings');

Route::get('/userdrawings', function () {
    return view('pages.userdrawings');
})->name('userdrawings');

Route::get('/preferences', function () {
    return view('pages.settingscontents.preferences');
})->name('preferences');

Route::get('/profile', function () {
    return view('pages.settingscontents.profile');
})->name('profile');

Route::get('/account', function () {
    return view('pages.settingscontents.account');
})->name('account');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

