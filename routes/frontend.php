<?php
/**
 * Created by PhpStorm.
 * User: jaiminwu-stuff
 * Date: 2017/11/25
 * Time: 下午7:16
 */
use Illuminate\Http\Request;

Route::middleware('web')->group(function (){
    Route::get('user/login', 'UserController@login');
    Route::get('user/register', 'UserController@register');
    Route::get('user/checkLogin', 'UserController@checkLogin');
    Route::get('user/changePassword', 'UserController@changePassword');
    Route::get('user/logout', 'UserController@logout');
    Route::get('code/send', 'CodeController@send');
});

Route::middleware('user_login', 'web')->group(function (){
    Route::get('user/info', 'UserController@show');
    Route::get('user/identify', 'UserController@identify');
    Route::get('user/identity', 'UserController@identity');
    Route::get('bill/borrow', 'BillController@borrow');
    Route::get('bill/repay', 'BillController@repay');
    Route::get('bill/borrowList', 'BillController@borrowList');
    Route::get('bill/repayList', 'BillController@repayList');
    Route::get('bill/test', 'BillController@test');
    Route::get('message/list', 'MessageController@list');
    Route::get('message/info', 'MessageController@info');
    Route::get('/test3', function(){});
});

Route::get('/test1', function (Request $request){
//    $request->session()->put('user_id', '321');
    $user_id = $request->session()->get('user_id');
    echo $user_id;
})->middleware('web');



