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

    public function checkLogin(Request $request){
        $user_id = $request->session()->get('user_id', null);
        if(empty($user_id)){
            $this->errorHandler(303, $user_id);
            exit();
        }
//        $user_id = '15';
//        $this->errorHandler(1, $user_id);
        $this->errorHandler(1);

    }


    public function show(Request $request){

    }

    public function register(Request $request){
        $user_info = $request->all();
        $user = new User;
        $this->checkUserExist($user_info['phone']);
        $verify_code = new CodeController;
        $verify_code->checkCodeAvailable($user_info['phone'], $user_info['code']);
        unset($user_info['code']);
        $user_info['password'] = md5($user_info['password'].config('app.secret_key'));
        $user_info['create_at'] = date('YmdHis');
        $user_id = $user->insertGetId($user_info);
        $identity = new Identity;
        $identity->user_id = $user_id;
        $identity->save();
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
        $identity = Identity::where('user_id', $request->session()->get('user_id', null))
                        ->first();
        if(empty($identity)){
            $identity = new Identity;
        }
        $identity->user_id = $request->session()->get('user_id', null);
        $identity->name = $identify_info['name'];
        $identity->id_num = $identify_info['id_num'];
        $identity->phone = $identify_info['phone'];
        $identity->wechat_id = $identify_info['wechat_id'];
        $identity->qq_id = $identify_info['qq_id'];
        $identity->address = $identify_info['address'];
        $identity->if_verified = 0;
        $identity->save();
        $this->errorHandler(1, $request->session()->get('user_id', null));
    }

    public function identity(Request $request){
        $user_id = $request->session()->get('user_id', null);
        $identity = Identity::where('user_id', $user_id)->first();
        if(empty($identity)){
            $this->errorHandler(101);
            exit();
        }
        $this->errorHandler(1, $identity);
    }

}