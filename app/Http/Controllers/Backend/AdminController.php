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

    }

    public function delete(Request $request){

    }

    public function login(Request $request){

    }

    public function logout(Request $request){

    }

}