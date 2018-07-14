<?php
/**
 * User: zjx
 * Date: 2018/7/14
 * Time: 15:08
 */

// 监控服务
class Server
{
    const  PORT = 8811;

    public function port()
    {
        $shell = "netstat -anp 2>/dev/null | grep " . self::PORT . ' | grep LISTEN | wc -l';

        $result = shell_exec($shell);

        if ($result != 1) {
            // 发送报警信息
            echo "error" . PHP_EOL;
        }
    }
}

swoole_timer_tick(2000, function ($timer_id) {
    (new Server())->port();
});