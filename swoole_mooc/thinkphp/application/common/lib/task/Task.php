<?php
/**
 * User: zjx
 * Date: 2018/7/2
 * Time: 22:00
 */

namespace app\common\lib\task;

use app\common\lib\ali\Sms;
use app\common\lib\Redis;
use app\common\lib\redis\Predis;

class Task
{
    /**
     * 异步发送验证码
     *
     * @param $data
     * @param $serv
     * @return boolean
     * @throws
     */
    public function sendSms($data, $serv)
    {
        try {
            $response = Sms::sendSms($data['phone'], $data['code']);
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }

        if ($response->Code === "OK") {
            Predis::getInstance()->set(Redis::smsKey($data['phone']), $data['code'], config('redis.out_time'));
        } else {
            return false;
        }

        return true;
    }

    /**
     * 发送赛况
     * @param $data
     * @param $serv
     * @throws \Exception
     */
    public function pushLive($data, $serv)
    {
        $clients = Predis::getInstance()->sMembers(config('redis.live_game_key'));

        foreach ($clients as $client) {
            $serv->push($client, json_encode($data));
        }
    }
}