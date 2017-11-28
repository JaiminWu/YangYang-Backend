<?php
/**
 * Created by PhpStorm.
 * User: jaiminwu-stuff
 * Date: 2017/11/25
 * Time: 下午9:50
 */

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;

header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class MessageController extends Controller
{

    public function list(Request $request){
        $user_id = $request->session()->get('user_id', null);
        $message_array = Message::where('user_id', $user_id)
                                ->get();
        $this->errorHandler(1, $message_array);
    }

    public function info(Request $request){
        $user_id = $request->session()->get('user_id', null);
        $message_id = $request->get('message_id');
        $message_info = Message::where(['user_id' => $user_id, 'message_id' => $message_id])
            ->get();
        $this->errorHandler(1, $message_info);
    }


}