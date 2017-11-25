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
        $this->checkAccountExist($user_input);
        $user_info = $this->checkPassword($user_input);
        $request->session()->put('user_id', $user_info['user_id']);
        $this->errorHandler(1, $request->session()->all());
    }

    private function checkAccountExist($user_input){
        $check_account_exist = User::where('phone', $user_input['phone'])
            ->first();
        if(!$check_account_exist){
            $this->errorHandler(301);
        }
        return true;
    }

    private function checkPassword($user_input){
        $user_info = User::where('password', $user_input['password'])
            ->first();
        if(!$user_info){
            $this->errorHandler(302);
        }
        return $user_info;
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        $this->errorHandler();
    }

    public function show(Request $request){
        $user_id = $request->session()->get('user_id', null);
        $user = User::findOrFail($user_id);
        $this->errorHandler(1, $user);
    }

    public function create(){

    }

    public function store(Request $request){

    }



}