<?php
/**
 * User: zjx
 * Date: 2018/6/25
 * Time: 21:48
 */

$redisClient = new swoole_redis;

$redisClient->connect('127.0.0.1', 6379, function (swoole_redis $redisClient, $result) {
    echo "connect" . PHP_EOL;
    var_dump($result);

    $redisClient->set('singwa_1', time(), function (swoole_redis $redisClient, $result) {
        var_dump($result);
    });

    $redisClient->get('singwa_1', function(swoole_redis $redisClient, $result){
        var_dump($result);
        $redisClient->close();
    });

    $redisClient->keys('*', function(swoole_redis $redisClient, $result){
        var_dump($result);
        $redisClient->close();
    });
});

echo "start" . PHP_EOL;