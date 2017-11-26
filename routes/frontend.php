<?php
/**
 * Created by PhpStorm.
 * User: jaiminwu-stuff
 * Date: 2017/11/25
 * Time: 下午7:16
 */
use Illuminate\Http\Request;

Route::get('user/login', 'UserController@login');
Route::get('user/register', 'UserController@register');
Route::get('user/changePassword', 'UserController@changePassword');
Route::get('user/logout', 'UserController@logout');
Route::get('code/send', 'CodeController@send');

Route::middleware('user_login')->group(function (){
    Route::get('user/info', 'UserController@show');
    Route::get('user/register', 'UserController@register');
    Route::get('user/identify', 'UserController@identify');
    Route::get('bill/borrow', 'BillController@borrow');
    Route::get('bill/repay', 'BillController@repay');
    Route::get('bill/borrowList', 'BillController@borrowList');
    Route::get('bill/repayList', 'BillController@repayList');
    Route::get('bill/test', 'BillController@test');
    Route::get('message/list', 'MessageController@list');
    Route::get('message/info', 'MessageController@info');
});

//Route::get('/test', function (){
//
//});
