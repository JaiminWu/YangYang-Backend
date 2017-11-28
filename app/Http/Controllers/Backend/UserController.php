<?php
/**
 * Created by PhpStorm.
 * User: jaiminwu-stuff
 * Date: 2017/11/28
 * Time: 下午5:44
 */

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Identity;


header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');
class UserController extends Controller
{

    public function list(Request $request){
        //adult 0 为学生，1为已成年
        $adult = $request->get('adult');
        $user_array = $this->getList($adult);
        if(empty($user_array)){
            $this->errorHandler(101, $user_array);
            return 0;
        }
        $this->errorHandler(1, $user_array);
    }

    private function getList($adult){
        $user_array = User::where('adult', $adult)
                        ->leftJoin('identities', 'identities.user_id', '=', 'users.user_id')
                        ->get();
        return $user_array;

    }

    public function info(Request $request){
        $user_id = $request->get('user_id');
        $user_info = User::where('user_id', $user_id)
                        ->first();
        $identity_info = Identity::where('user_id', $user_id)
                                ->first();
        $user_info['identity_info'] = $identity_info;
        $this->errorHandler(1, $user_info);
    }

    public function verify(Request $request){
        $user_id = $request->get('user_id');
        $identity = Identity::where('user_id', $user_id)->first();
        $identity->if_verified = 1 - $identity->if_verified;
        $identity->save();
        $this->errorHandler();
    }



}