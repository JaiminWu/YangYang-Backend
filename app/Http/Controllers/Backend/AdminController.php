<?php
/**
 * Created by PhpStorm.
 * User: jaiminwu-stuff
 * Date: 2017/11/25
 * Time: 下午7:01
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Admin;


header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class AdminController extends Controller
{

    public function list(Request $request){

    }

    public function info(Request $request){

    }

    public function update(Request $request){
//        $admin_info = $request->all();
//        $admin =
//        if($admin_info['admin_id']){
//            $admin = new Admin;
//        }


    }

    public function delete(Request $request){

    }

    public function login(Request $request){
        $login_input = $request->all();
        if(!$this->ifUserExist($login_input['account'])){
            $this->errorHandler(301);
            exit();
        }
        $admin = $this->checkPassword($login_input['account'], $login_input['password']);
        if(!$admin){
            $this->errorHandler(302);
            exit();
        }
        $request->session()->put('admin_id', $admin['admin_id']);
        $this->errorHandler(1, $login_input);
    }

    public function logout(Request $request){
        $request->session()->forget('admin_id');
        $this->errorHandler();
    }

    private function ifUserExist($account){
        $admin = Admin::where('account', $account)->first();
        if(empty($admin)){
            return false;
        } else {
            return $admin;
        }

    }

    private function checkPassword($account, $password){
        $map['account'] = $account;
//        $map['password'] = md5($password.config('app.secret_key'));
        $map['password'] = $password;
        $admin = Admin::where($map)->first();
        if(empty($admin)){
            return false;
        } else {
            return $admin;
        }
    }

}