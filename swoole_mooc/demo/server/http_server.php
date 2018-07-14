<?php
/**
 * User: zjx
 * Date: 2018/6/13
 * Time: 22:26
 */

$http = new swoole_http_server("0.0.0.0", 8811);

$http->set(
    [
        'enable_static_handler' => true,
        'document_root' => '/home/vagrant/Code/swoole_mooc/data',
    ]
);

$http->on('request', function ($request, $response) {
    // print_r($request->get);
    // $response->end("<h1>HTTP SERVER</h1>");
    $content = [
        "data: " => date('Y-m-d H:i:s'),
        "get: " => $request->get,
        "post: " => $request->post,
        "header: " => $request->header,
    ];

    swoole_async_writefile(__DIR__ . '/access.log', json_encode($content), function ($filename) {
        echo "success" . PHP_EOL;
    }, FILE_APPEND);

    $response->cookie('singwa', 'xsssss', time() + 1800);
    $response->end('ss' . json_encode($request->get));
});

$http->start();