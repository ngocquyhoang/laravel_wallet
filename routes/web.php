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

Route::get('/', function () { return view('welcome'); });
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Auth::routes();

Route::resource('user', 'UserController')->only(['update']);
Route::put('/user/{user}/update_password', 'UserController@update_password')->name('update_password');
