<?php
/**
 * User: zjx
 * Date: 2018/7/12
 * Time: 20:19
 */

namespace app\index\controller;
use app\common\lib\Util;

class Chart
{
    public function index()
    {
        if (empty($_POST['game_id'])) {
            return Util::show(config('code.error'), 'error');
        }

        if (empty($_POST['content'])) {
            return Util::show(config('code.error'), 'error');
        }

        $data = [
            'user' => '用户'.rand(1,999),
            'content' => $_POST['content']
        ];
        foreach ($_POST['http_server']->ports[1]->connections as $fd) {
            dump($fd);
            $_POST['http_server']->push($fd, json_encode($data));
        }

        return Util::show(config('code.success'), 'ok');
    }
}