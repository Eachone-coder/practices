<?php
/**
 * User: zjx
 * Date: 2018/6/29
 * Time: 20:53
 */

namespace app\index\controller;

use app\common\lib\redis\Predis;
use app\common\lib\Util;
use app\common\lib\Redis;

class Login
{
    public function index()
    {
        $phoneNum = request()->get('phone_num');
        $code = request()->get('code');

        if (empty($phoneNum) || empty($code)) {
            return Util::show(config('code.error'), 'phone or code is error');
        }
        try {
            $redisCode = Predis::getInstance()->get(Redis::smsKey($phoneNum));
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        if ($redisCode != $code) {
            return Util::show(config('code.error'), 'code is error');
        }

        $data = [
            'user' => $phoneNum,
            'srcKey' => md5(Redis::userKey($phoneNum)),
            'time' => time(),
            'isLogin' => true,
        ];

        Predis::getInstance()->set(Redis::userKey($phoneNum), $data);

        return Util::show(config('code.success'), 'ok', $data);
    }
}