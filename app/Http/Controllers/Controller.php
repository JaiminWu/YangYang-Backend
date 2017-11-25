<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function errorHandler($code=1, $data=''){
        switch ($code){
            case 301:
                $msg = '账号不存在，请注册新账户';
                break;
            case 302:
                $msg = '账号不存在，请注册新账户';
                break;
            default:
                $msg = '请求成功！';
                break;
        }
        $output['data'] = $data;
        $output['code'] = $code;
        $output['msg'] = $msg;
        echo json_encode($output);
        exit();
    }
}
