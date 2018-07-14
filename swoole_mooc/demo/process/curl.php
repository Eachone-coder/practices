<?php
/**
 * User: zjx
 * Date: 2018/6/26
 * Time: 20:41
 */

echo "process-start-time:" . date('Y-m-d H:i:s') . PHP_EOL;

$urls = [
    'http://baidu.com',
    'http://sina.com.cn',
    'http://qq.com',
    'http://baidu.com?search=singwa',
    'http://baidu.com?search=singwa2',
    'http://baidu.com?search=imooc',
];

for ($i = 0; $i < 6; $i++) {
    $process = new swoole_process(function (swoole_process $worker) use ($i, $urls) {
        $content = curlData($urls[$i]);
        echo $content . PHP_EOL;
    }, true);

    $pid = $process->start();
    $workers[$pid] = $process;
}

foreach ($workers as $worker) {
    echo $worker->read();
}

function curlData($url)
{
    sleep(1);

    return $url . "  succrss" . PHP_EOL;
}

echo "process-end-time:" . date('Y-m-d H:i:s') . PHP_EOL;