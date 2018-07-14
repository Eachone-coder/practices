<?php
/**
 * User: zjx
 * Date: 2018/6/14
 * Time: 20:55
 */

$server = new swoole_websocket_server("0.0.0.0", 8812);

$server->set(
    [
        'enable_static_handler' => true,
        'document_root' => '/home/vagrant/Code/swoole_mooc/data',
    ]
);

// $server->on('open', function (swoole_websocket_server $server, $request) {
//     echo "server: handshake success with fd{$request->fd}\n";
// });

// 监听 websocket 连接打开事件
$server->on('open', 'onOpen');

function onOpen($server, $request){
    print_r($request->fd);
}

// 监听 websocket 消息事件
$server->on('message', function (swoole_websocket_server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "this is server");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();