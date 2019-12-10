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

Auth::routes();

//Route::get('/', function () {    return view('welcome'); });
//Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
//Route::get('/regsforandroid', 'regsForAndroidController@index');

Route::get('/', 'HomeController@index')->name('home');
//Route::get('{path}', 'HomeController@index')->where( 'path', '([A-z\d-\/_.]+)?' );
//Route::get('{path}','HomeController@index')->where( 'path', '([A-z]+)?' );
Route::get('{path}',"HomeController@index")->where('path','[-a-z0-9_\s]+');


