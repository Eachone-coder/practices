<?php
/**
 * User: zjx
 * Date: 2018/6/13
 * Time: 22:17
 */

$client = new swoole_client(SWOOLE_SOCK_UDP);

if (!$client->connect('127.0.0.1', 9502)) {
    echo "连接失败";
    exit;
}

fwrite(STDOUT, "请输入消息：");
$msg = trim(fgets(STDIN));

// 发送消息到 server
$client->send($msg);

// 接收 server 的数据
$result = $client->recv();
echo $result;

