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
Route::redirect('/', 'index.html');
Route::redirect('/home', 'index.html');

Route::get('user/login', 'Frontend\UserController@login');
Route::get('user/test', 'Frontend\UserController@test');




Route::resource('photos', 'PhotoController');





