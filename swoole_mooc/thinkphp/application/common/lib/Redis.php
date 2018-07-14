<?php
/**
 * User: zjx
 * Date: 2018/6/28
 * Time: 21:58
 */

namespace app\common\lib;

class Redis
{
    // 验证码前缀
    public static $pre = "sms_";

    public static $userPre = 'user_';

    /**
     * 存储验证码的 key 值
     *
     * @param $phone
     * @return string
     */
    public static function smsKey($phone)
    {
        return self::$pre . $phone;
    }

    public static function userKey($phone)
    {
        return self::$userPre . $phone;
    }
}