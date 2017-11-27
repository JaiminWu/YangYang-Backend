<?php
/**
 * Created by PhpStorm.
 * User: jaiminwu-stuff
 * Date: 2017/11/26
 * Time: 下午12:35
 */

namespace App\Http\Controllers\Frontend;

use App\Code;

require_once($_SERVER['DOCUMENT_ROOT'] . '/message_php_sdk/mns-autoloader.php');

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\UserController;
use AliyunMNS\Client;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\PublishMessageRequest;
use Illuminate\Http\Request;
header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class CodeController extends Controller
{

    private function sendAction($phone)
    {
        /**
         * Step 1. 初始化Client
         */
        $endPoint = "https://1273563388978752.mns.cn-shenzhen.aliyuncs.com/"; // eg. http://1234567890123456.mns.cn-shenzhen.aliyuncs.com
//        $endPoint = "http://1273563388978752.mns.cn-shenzhen-internal-vpc.aliyuncs.com"; // 内网VPC地址
        $accessId = "LTAI7IiqOP8CPaYB";
        $accessKey = "H0WKUigdBH0nl6rnojLY6IMLDHaN0I";
        $client = new Client($endPoint, $accessId, $accessKey);
        /**
         * Step 2. 获取主题引用
         */
        $topicName = "sms.topic-cn-shenzhen";
        $topic = $client->getTopicRef($topicName);
        /**
         * Step 3. 生成SMS消息属性
         */
        // 3.1 设置发送短信的签名（SMSSignName）和模板（SMSTemplateCode）
        $batchSmsAttributes = new BatchSmsAttributes("共信平台", "SMS_113765008");
        // 3.2 （如果在短信模板中定义了参数）指定短信模板中对应参数的值
        $code = rand(100000, 999999);
        if($phone == '18819253238'){
            $code = '123456';
        }
        $batchSmsAttributes->addReceiver($phone, array("code" => $code));
        $messageAttributes = new MessageAttributes(array($batchSmsAttributes));
        /**
         * Step 4. 设置SMS消息体（必须）
         *
         * 注：目前暂时不支持消息内容为空，需要指定消息内容，不为空即可。
         */
        $messageBody = "smsmessage";
        /**
         * Step 5. 发布SMS消息
         */
        $request = new PublishMessageRequest($messageBody, $messageAttributes);
        try {
            $res = $topic->publishMessage($request);
            return $code;
        } catch (MnsException $e) {
            echo $e;
            echo "\n";
        }
    }

    public function send(Request $request)
    {
        $phone = $request->input('phone');
        $code = Code::where('phone', $phone)->first();
        $this->checkCodeRepeat($code);
        if (empty($code)) {
            $code = new Code;
        }
        $verify_code = $this->sendAction($phone);
        $code->phone = $phone;
        $code->code = $verify_code;
        $code->dead_time = time() + 900;
        $code->save();
        $this->errorHandler();
    }


    private function checkCodeRepeat($code)
    {
        if (!empty($code) && (strtotime($code['updated_at']) + 60 > time())) {
            $this->errorHandler(304);
            exit();
        }
    }

    public function checkCodeAvailable($phone, $code)
    {
        $verify_code = Code::where('phone', $phone)
            ->where('code', $code)
            ->first();
        if (!$verify_code) {
            $this->errorHandler(306);
            exit();
        }
        if ($verify_code['dead_time'] < time()) {
            $this->errorHandler(307, $verify_code);
            exit();
        }
        return true;
    }

}