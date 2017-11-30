<?php
/**
 * Created by PhpStorm.
 * User: jaiminwu-stuff
 * Date: 2017/11/25
 * Time: 下午7:16
 */

use Illuminate\Http\Request;

Route::post('admin/admin/login', 'AdminController@login');
Route::get('admin/admin/logout', 'AdminController@logout');

Route::middleware('admin_login')->group(function(){
    Route::get('admin/user/info', 'UserController@info');
    Route::get('admin/user/verify', 'UserController@verify');
    Route::get('admin/user/list', 'UserController@list');
    Route::get('admin/admin/list', 'AdminController@list');
    Route::get('admin/admin/info', 'AdminController@info');
    Route::get('admin/admin/update', 'AdminController@update');
    Route::get('admin/admin/delete', 'AdminController@delete');
    Route::get('admin/bill/list', 'BillController@list');
    Route::get('admin/bill/info', 'BillController@info');
    Route::get('admin/bill/update', 'BillController@update');
});



