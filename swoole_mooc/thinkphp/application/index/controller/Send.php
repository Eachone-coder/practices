<?php
/**
 * User: zjx
 * Date: 2018/6/27
 * Time: 21:55
 */

namespace app\index\controller;

use app\common\lib\ali\Sms;
use app\common\lib\Util;
use app\common\lib\Redis;

class Send
{
    /**
     * 发送验证码
     */
    public function index()
    {
        $phoneNum = request()->get('phone_num', 0, 'intval');
        if (empty($phoneNum)) {
            return Util::show(config('code.error'), 'error');
        }

        $code = rand(1000, 9999);

        $taskData = [
            'method' => 'sendSms',
            'data' =>[
                'phone' => $phoneNum,
                'code' => $code,
            ]
        ];

        $_POST['http_server']->task($taskData);

        return Util::show(config('code.success'), 'success');
        // try {
        //     $response = Sms::sendSms($phoneNum, $code);
        // } catch (\Exception $e) {
        //     return Util::show(config('code.error'), '阿里大于内部异常');
        // }
        //
        // if ($response->Code === "OK") {
        //     $redis = new \Swoole\Coroutine\Redis();
        //     $redis->connect(config('redis.host'), config('redis.port'));
        //     $redis->set(Redis::smsKey($phoneNum), $code, config('redis.out_time'));
        //     return Util::show(config('code.success'), 'success');
        // } else {
        //     return Util::show(config('code.error'), 'error');
        // }
    }
}