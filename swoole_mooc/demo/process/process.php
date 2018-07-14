<?php
/**
 * User: zjx
 * Date: 2018/6/25
 * Time: 22:27
 */

$process = new swoole_process(function (swoole_process $pro) {
    $pro->exec('/usr/bin/php7.1', [__DIR__.'/../server/http_server.php']);
}, true);

$pid = $process->start();

echo $pid . PHP_EOL;

swoole_process::wait();

