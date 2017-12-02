<?php
/**
 * Created by PhpStorm.
 * User: jaiminwu-stuff
 * Date: 2017/11/28
 * Time: 下午4:51
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Bill;


header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class BillController extends Controller
{

    public function list(Request $request){
        $user_id = $request->get('user_id');
        $bill = new Bill;
        $bill_array = $bill->where('user_id', $user_id)->get();
        $this->errorHandler(1, $bill_array);
    }

    public function info(Request $request){
        $bill_id = $request->get('bill_id');
        $bill_info = Bill::where('bill_id', $bill_id)
            ->first();
        $this->errorHandler(1, $bill_info);
    }

    public function update(Request $request){
        $bill_id = $request->get('bill_id');
        $bill = Bill::find($bill_id);
        $bill->status = $request->get('status');
        if($bill->status == 2){
            $bill->repaid_at = date('YmdHis');
        }
//        $bill->deadline_at = $request->get('deadline_at');
        $bill->save();
        $this->errorHandler();

    }
}