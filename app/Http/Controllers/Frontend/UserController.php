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
use App\Identity;

header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user_input = $request->all();
        $user_info = $this->checkUserNotExist($user_input['phone']);
        $this->checkPassword($user_input['password']);
        $request->session()->put('user_id', $user_info['user_id']);
        $this->errorHandler(1, $request->session()->get('user_id'));
    }

    private function checkUserNotExist($phone){
        $check_account_exist = User::where('phone', $phone)
            ->first();
        if(!$check_account_exist){
            $this->errorHandler(301);
        }
        return $check_account_exist;
    }

    private function checkPassword($password){
        $user_info = User::where('password', md5($password.config('app.secret_key')))
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

    }

    public function register(Request $request){
        $user_info = $request->all();
        $user = new User;
        $this->checkUserExist($user_info['phone']);
        $verify_code = new CodeController;
        $verify_code->checkCodeAvailable($user_info['phone'], $user_info['code']);
        $user_id = $user->insertGetId([
            'phone' => $user_info['phone'], 'password' => md5($user_info['password'].config('app.secret_key')),
            'referrer' => $user_info['referrer']
            ]);
        $request->session()->put('user_id', $user_id);
        $this->errorHandler();
    }

    public function changePassword(Request $request){
        $user_info = $request->all();
        $user = $this->checkUserNotExist($user_info['phone']);
        $verify_code = new CodeController;
        $verify_code->checkCodeAvailable($user_info['phone'], $user_info['code']);
        $user->phone = $user_info['phone'];
        $user->password = md5($user_info['password'].config('app.secret_key'));
        $user->save();
        $request->session()->put('user_id', $user->user_id);
        $this->errorHandler();
    }

    public function checkUserExist($phone){
        $user = User::where('phone', $phone)->first();
        if($user){
            $this->errorHandler(305);
            exit();
        }
        return $user;
    }

    public function identify(Request $request){
        $identify_info = $request->all();
        $identity = new Identity;
        $identity->user_id = $request->session()->get('user_id', null);
        $identity->name = $identify_info['name'];
        $identity->id_num = $identify_info['id_num'];
        $identity->wechat_id = $identify_info['wechat_id'];
        $identity->qq_id = $identify_info['qq_id'];
        $identity->address = $identify_info['address'];
        $identity->save();
        $this->errorHandler(1, $request->session()->get('user_id', null));
    }

}