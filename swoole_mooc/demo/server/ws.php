<?php
/**
 * User: zjx
 * Date: 2018/6/14
 * Time: 22:06
 */

class Ws
{
    CONST HOST = "0.0.0.0";
    CONST PORT = 8812;

    public $ws = null;

    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);

        $this->ws->on("open", [$this, 'onOpen']);

        $this->ws->on("message", [$this, 'onMessage']);

        $this->ws->on("close", [$this, 'onClose']);

        $this->ws->start();
    }

    /**
     * 监听 ws 连接事件
     *
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request)
    {
        var_dump($request->fd);
        if ($request->fd == 1) {
            swoole_timer_tick(2000, function ($timer_id) {
                echo "2s: timerId:{$timer_id}\n";
            });
        }
    }

    /**
     * 监听 ws 消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame)
    {
        echo "ser-push-message:{$frame->data}\n";
        $data = [
            'task' => 1,
            'fd' => $frame->fd,
        ];

        // $ws->task($data);

        swoole_timer_after(5000, function() use ($ws, $frame) {
            echo "5s-after\n";
            $ws->push($frame->fd, "server-timer-after:");
        });

        $ws->push($frame->fd, "server-push:" . date('Y-m-d H:i:s'));
    }

    /**
     * ws 关闭事件
     *
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd)
    {
        echo "clientid:{$fd}\n";
    }
}

$obj = new Ws();

