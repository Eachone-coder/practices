<?php
/**
 * User: zjx
 * Date: 2018/6/28
 * Time: 21:41
 */

namespace app\common\lib;

class Util
{
    /**
     * ajax 返回
     *
     * @param $status
     * @param string $message
     * @param array $data
     * @return string
     */
    public static function show($status, $message = "", $data = [])
    {
        $result = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];

        return json_encode($result);
    }
}