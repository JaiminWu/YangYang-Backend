<?php
/**
 * Created by PhpStorm.
 * User: jaiminwu-stuff
 * Date: 2017/11/25
 * Time: 下午7:35
 */

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bill;
use App\Identity;

header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class BillController extends Controller
{
    public function borrow(Request $request){
        $borrow_info = $request->all();
        $this->borrowCreate($borrow_info);
        $this->errorHandler();
    }

    private function borrowCreate($borrow_info){
        $bill = new Bill;
        $bill->user_id = session('user_id');
        $bill->borrow = $borrow_info['borrow'];
        $bill->type = $borrow_info['type'];
        $bill->applied_at = date('YmdHis');
        $bill->save();
        return true;
    }

    public function borrowList(Request $request){
        $borrow_sent = $request->get('borrow_sent');
        $borrow_array = $this->getList('borrow_sent', $borrow_sent);
        $this->errorHandler(1, $borrow_array);

    }

    public function repayList(Request $request){
        $paid_off = $request->get('paid_off');
        $repay_array = $this->getList('paid_off', $paid_off);
        $this->errorHandler(1, $repay_array);
    }

    private function getList($type, $index){
        $user_id = session('user_id');
        $list_array = Bill::where([$type => $index, 'bills.user_id' => $user_id])
            ->leftJoin('identities', 'bills.user_id', '=', 'identities.user_id')
            ->get();
        if(empty($list_array)){
            $this->errorHandler(101);
            exit();
        }
        return $list_array;
    }

    public function unrepaidInfo(){
        $user_id = session('user_id');
        $list_info = Bill::where(['borrow_sent' => 1, 'paid_off' => 0,'bills.user_id' => $user_id])
            ->first();
//        if(empty($list_info)){
//            $this->errorHandler(101);
//            exit();
//        }
        $this->errorHandler(1, $list_info);
    }


}