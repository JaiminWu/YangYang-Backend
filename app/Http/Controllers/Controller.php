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
            case 101:
                $msg = '查询结果为空';
                break;
            case 301:
                $msg = '账号不存在，请注册新账户';
                break;
            case 302:
                $msg = '密码错误，请重试！';
                break;
            case 303:
                $msg = '登录态失效，请重新登录。';
                break;
            case 304:
                $msg = '60秒内不可重复发送验证码。';
                break;
            case 305:
                $msg = '账户已存在，请直接登录！';
                break;
            case 306:
                $msg = '验证码错误！';
                break;
            case 307:
                $msg = '验证码已失效，请重新发送验证码';
                break;
            default:
                $msg = '请求成功！';
                break;
        }
        $output['data'] = $data;
        $output['code'] = $code;
        $output['msg'] = $msg;
        echo json_encode($output);
    }
}
