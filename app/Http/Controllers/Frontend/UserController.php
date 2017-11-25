<?php
/**
 * Created by PhpStorm.
 * User: jaiminwu-stuff
 * Date: 2017/11/25
 * Time: 下午4:10
 */


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user_input = $request->all();
        $check_account_exist = User::where('phone', $user_input['phone'])
                            ->first();
        if(!$check_account_exist){
            $this->errorHandler(301);
        }
        $check_login = User::where('password', $user_input['password'])
            ->first();
        if(!$check_login){
            $this->errorHandler(302);
        }
        $this->errorHandler();
    }

    public function test()
    {
        $check_account_exist = User::all();
        $this->errorHandler(1, $check_account_exist);
    }


}