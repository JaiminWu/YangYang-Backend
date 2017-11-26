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
        $this->checkUserNotExist($user_input);
        $user_info = $this->checkPassword($user_input);
        $request->session()->put('user_id', $user_info['user_id']);
        $this->errorHandler();
    }

    private function checkUserNotExist($user_input){
        $check_account_exist = User::where('phone', $user_input['phone'])
            ->first();
        if(!$check_account_exist){
            $this->errorHandler(301);
        }
        return true;
    }

    private function checkPassword($user_input){
        $user_info = User::where('password', md5($user_input['password'].config('app.secret_key')))
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

    public function register(Request $request){
        $user_info = $request->all();
        $user = new User;
        $this->checkUserExist($user_info['phone']);
        $verify_code = new CodeController;
        $verify_code->checkCodeAvailable($user_info['phone'], $user_info['code']);
        $user->phone = $user_info['phone'];
        $user->password = md5($user_info['password'].config('app.secret_key'));
        $user->referrer = $user_info['referrer'];
        $user->save();
        $this->errorHandler();
    }

    public function changePassword(Request $request){

    }

    public function checkUserExist($phone){
        if(User::where('phone', $phone)->first()){
            $this->errorHandler(305);
            exit();
        }
    }

}