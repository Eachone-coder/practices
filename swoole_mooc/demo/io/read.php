<?php
/**
 * User: zjx
 * Date: 2018/6/20
 * Time: 21:32
 */

/**
 * 读取文件
 */
$result = swoole_async_readfile(__DIR__ . '/1.txt', function ($filename, $fileContent) {
    echo "filename:" . $filename . PHP_EOL;
    echo "content:" . $fileContent . PHP_EOL;
});

var_dump($result);

echo "start".PHP_EOL;